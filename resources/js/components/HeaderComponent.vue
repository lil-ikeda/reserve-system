<template>
    <div class="header">
        <div class="header__wrapper">
            <router-link class="text-decoration-none font-white" v-bind:to="{name: 'event.list'}">
                <span class="header__wrapper--title">スキルハック・エントリーシステム</span>
                <span @click="logout">ログアウト</span>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            async logout() {
                await this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }
        }
    }
</script>