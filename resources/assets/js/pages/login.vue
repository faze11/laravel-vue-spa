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
                                placeholder="Password">
                            </b-form-input>
                            <input-help :form="form" field="password" text=""></input-help>
                        </b-form-group>
                        
                        <busy-button variant="primary" type="submit" :busy="busy">Login</busy-button>

                        <div class="mt-3 text-center">
                            Don't have an account?  <router-link :to="{ name: 'register' }">Sign Up Now</router-link>!
                        </div>

                        <div class="mt-3 text-center">
                            <router-link :to="{ name: 'forgot-password' }">I forgot my password</router-link>
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
        return { title: "Login" }
    },

    data: () => ({
        form: new Form({
            email: '',
            password: ''
        }),
        remember: false,
        busy: false,
    }),

    methods: {
        async submit() {
            this.busy = true;
            
            // Submit the form.
            await this.form.post(this.urls.auth + 'login')
                .then( ({ data }) => {
                    // Save the token.
                    this.$store.commit('auth/saveToken', {
                        token: data.data.token,
                        remember: this.remember
                    })

                    this.loadDashboard();
                })
                .catch( e => {
                    this.busy = false;
                });
        },

        async loadDashboard() {
            // Fetch the user.
            await this.$store.dispatch('auth/fetchUser')

            if (this.user.role === 'admin') {
                this.$router.push({ name: 'admin.dashboard' })
                return;
            }
            
            // Redirect home.
            this.$router.push({ name: 'home' })
        },
    }
}
</script>
