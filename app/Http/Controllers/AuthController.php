<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\Http\Requests\SignupRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        ResetsPasswords::broker insteadof SendsPasswordResetEmails;
    }

    /**
     * Validate user credentials and return JWT token
     *
     * @param LoginRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $req)
    {
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($req->validated())) {
                return $this->fail(401, 'Login and password do not match.');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->fail(401, 'An unexpected error occurred.  Please try again.');
        }

        // all good so return the token
        return $this->success(null, [
            'user' => auth()->user(),
            'token' => $token,
        ]);
    }

    /**
     * Register user and return JWT token
     *
     * @param SignupRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(SignupRequest $req)
    {
        $data = $req->validated();

        $attributes = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];

        $user = User::create($attributes);

        // switch ($data['role']) {
        //     case 'client':
        //         $user = \App\Client::create($attributes);
        //         break;
        //     case 'user':
        //     default:
        //         $user = \App\MobileUser::create($attributes);
        //         break;
        // }

        // $user->assignRole($data['role']);

        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return $this->fail(401, 'An unexpected error occurred.  Please try again.');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->fail(401, 'An unexpected error occurred.  Please try again.');
        }

        // all good so return the token
        return $this->success(null, [
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Get the current user session
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userSession()
    {
        return $this->success(null, auth()->user());
    }

    /**
     * Handle forgot password submission and token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword()
    {
        $this->validateEmail(request());

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            request()->only('email')
        );

        return $this->success('Password reset link was sent.');
    }

    /**
     * Reset the user's password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword()
    {
        $this->validate(request(), $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials(request()),
            function ($user, $password) {
                $user->password = bcrypt($password);

                $user->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return $this->success('Your passsord has been reset.');
        } elseif ($response == Password::INVALID_TOKEN) {
            return $this->fail(422, 'This password reset token has expired.');
        }

        return $this->fail(500, 'Am unexpected error occurred while trying to reset your password.  Please try again.');
    }
}
