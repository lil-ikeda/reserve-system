<template>
    <div class="header">
        <div class="header__wrapper">
            <router-link class="text-decoration-none font-white" v-bind:to="{name: 'event.list'}">
                <span class="header__wrapper--title">予約システム</span>
            </router-link>
            <div class="header__link" v-if='isLogin'>
                <span @click="logout">ログアウト</span>
<!--                <img :src="`/storage/${useravatar}`" class="header__avatar">-->
            </div>
            <div class="header__link" v-else>
                <span @click="login">ログイン</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            isLogin() {
                return this.$store.getters['auth/check']
            },
            username() {
                return this.$store.getters['auth/username']
            },
            useravatar() {
                return this.$store.getters['auth/useravatar']
            }
        },
        methods: {
            async logout() {
                console.log('OK')
                await this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            },
            async login() {
                this.$router.push('/login')
            }
        },
    }
</script>
