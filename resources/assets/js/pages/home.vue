<template>
    <b-card header="Dashboard"
        class="card-primary"
    >
        <div>Hey {{ user.name }}</div>
    </b-card>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        middleware: ['auth'],

        metaInfo() {
            return { title: 'Dashboard' }
        },
        
        computed: mapGetters({
            user: 'auth/user'
        }),

        methods: {
            async logout () {
                this.$store.commit('auth/logout');
                this.$router.push({ name: 'login' });
            }
        }
    }
</script>
