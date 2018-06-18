<template>
    <b-container>
        <b-row>
            <b-col md="8" offset-md="2">
                <b-card header="Login" class="card-primary">
                    <b-form @submit.prevent="submit">
                        <b-form-group>
                            <b-form-input id="email"
                                :disabled="form.busy"
                                name="email"
                                type="email"
                                v-model="form.email"
                                required
                                placeholder="Email">
                            </b-form-input>
                            <input-help :form="form" field="email" text=""></input-help>
                        </b-form-group>

                        <b-form-group>
                            <b-form-input id="password"
                                :disabled="form.busy"
                                name="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                placeholder="New Password">
                            </b-form-input>
                            <input-help :form="form" field="password" text=""></input-help>
                        </b-form-group>

                        <b-form-group>
                            <b-form-input id="password_confirmation"
                                :disabled="form.busy"
                                type="password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm Password">
                            </b-form-input>
                            <input-help :form="form" field="password_confirmation" text=""></input-help>
                        </b-form-group>
                        
                        <busy-button variant="primary" type="submit" :busy="busy">Reset Password</busy-button>

                        <div class="mt-3 text-center">
                            Remember your password?  <router-link :to="{ name: 'login' }">Login</router-link>!
                        </div>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    middleware: 'guest',

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
    },

    metaInfo () {
        return { title: "Password Reset" }
    },

    data: () => ({
        form: new Form({
            email: '',
            password: '',
            password_confirmation: '',
            token: '',
        }),
        remember: false,
        busy: false,
    }),

    methods: {
        submit() {
            this.busy = true;
            
            // Submit the form.
            this.form.post(this.urls.auth + 'reset-password')
                .then( ({ data }) => {
                    this.$router.push({ name: 'home' });
                })
                .catch( e => {
                    this.busy = false;
                });
        },
    },

    mounted() {
        this.form.token = this.$route.query.token;
    },
}
</script>
