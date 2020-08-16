<template>
    <div class="header">
        <div class="header__wrapper">
            <router-link class="text-decoration-none font-white" v-bind:to="{name: 'event.list'}">
                <span class="header__wrapper--title">予約システム</span>
            </router-link>
            <div class="header__link" v-if='isLogin'>
                <span>{{ username }}</span>
                <router-link v-bind:to="{name: 'event.create'}">
                    <span>イベント作成</span>
                </router-link>
                <span @click="logout">ログアウト</span>
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
            }
        },
        methods: {
            async logout() {
                await this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            },
            async login() {
                this.$router.push('/login')
            }
        },
    }
</script>