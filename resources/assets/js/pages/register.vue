<template>
    <b-container>
        <b-row>
            <b-col md="8" offset-md="2">
                <b-card header="Register" class="card-primary">
                    <b-form @submit.prevent="submit">
                        <b-form-group>
                            <b-form-input id="name"
                                :disabled="form.busy"
                                type="text"
                                v-model="form.name"
                                required
                                placeholder="Your Name">
                            </b-form-input>
                            <input-help :form="form" field="name" text=""></input-help>
                        </b-form-group>
                        
                        <b-form-group>
                            <b-form-input id="email"
                                :disabled="form.busy"
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
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                placeholder="Password">
                            </b-form-input>
                            <input-help :form="form" field="password" text=""></input-help>
                        </b-form-group>
                                    
                        <busy-button variant="primary" type="submit" :busy="busy" >Sign Up</busy-button>

                        <div class="mt-3 text-center">
                            Already have an account?  <router-link :to="{ name: 'login' }">Login</router-link>!
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
        return { title: "Register" }
    },

    data: () => ({
        form: new Form({
            name: '',
            email: '',
            password: ''
        }),
        remember: false,
        busy: false,
    }),

    methods: {
        async submit() {
            this.busy = true;
            
            await this.form.post(this.urls.auth + 'signup')
                .then( ({ data }) => {
                    // Save the token.
                    this.$store.commit('auth/saveToken', {
                        token: data.data.token,
                        remember: this.remember
                    })

                    this.$router.push({ name: 'home' });
                })
                .catch( e => {
                    this.busy = false;
                });
        },
    }
}
</script>
