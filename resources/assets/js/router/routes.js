import Login from '../pages/login';
import Register from '../pages/register'
import Home from '../pages/home';
import ForgotPassword from '../pages/forgot-password';
import PasswordReset from '../pages/password-reset';

import NotFound from '../pages/errors/404';
import Test from '../pages/test';

export default [
    { path: '/test', name: 'test', component: Test },

    { path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/forgot-password', name: 'forgot-password', component: ForgotPassword },
    { path: '/password-reset', name: 'password-reset', component: PasswordReset },

    // catch all 404
    { path: '*', component: NotFound }
]
