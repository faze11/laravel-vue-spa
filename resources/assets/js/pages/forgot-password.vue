<template>
    <b-container>
        <b-row>
            <b-col md="8" offset-md="2">
                <b-card header="Reset Password" class="card-primary">
                    <div v-if="done">
                        <h4>A password reset confirmation has been sent to your email.</h4>
                    </div>
                    <b-form v-else @submit.prevent="submit">
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

                        <busy-button variant="primary" type="submit" :busy="busy">Send Password Reset Link</busy-button>
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
        return { title: "Reset Password" }
    },

    data: () => ({
        form: new Form({
            email: '',
        }),
        busy: false,
        done: false,
    }),

    methods: {
        submit() {
            this.busy = true;
            this.form.post(this.urls.auth + 'forgot-password')
                .then( ({ data }) => {
                    this.done = true;
                    this.busy = false;
                })
                .catch( e => {
                    this.busy = false;
                });
        },
    },
}
</script>
