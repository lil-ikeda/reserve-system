<template>
    <div class="login-wrapper">
        <ul class="tab">
            <li class="tab__item tab__item--login"
                :class="{'tab__item--active': tab === 1}"
                @click="tab = 1"
                >
                ログイン
            </li>
            <li class="tab__item tab__item--register" 
                :class="{'tab__item--active' : tab === 2}" 
                @click="tab = 2"
                >
                新規登録
            </li>
        </ul>

        <div class="panel" v-show="tab === 1">
            <form @submit.prevent="login">
                <label for="login-email">メールアドレス</label>
                <input type="text" id="login-email" v-model="loginForm.email">
                <label for="login-password">パスワード</label>
                <input type="password" id="login-password" v-model="loginForm.password">
                <button type="submit" class="btn-submit">ログイン</button>
            </form>
        </div>

        <div class="panel" v-show="tab === 2">
            <form @submit.prevent="register">
                <label for="name">名前</label>
                <input type="text" id="name" v-model="registerForm.name">
                <label for="email">メールアドレス</label>
                <input type="text" id="email" v-model="registerForm.email">
                <label for="password">パスワード</label>
                <input type="password" id="password" v-model="registerForm.password">
                <label for="password_confirmation">パスワード確認用</label>
                <input type="password" id="password-confirmation" v-model="registerForm.password_confirmation">
                <button type="submit" class="btn-submit">新規登録</button>
            </form>
        </div>
    </div>
</template>

<script>    
    export default {
        data() {
            return {
                tab: 1,
                loginForm: {
                    email: '',
                    password: ''
                },
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        methods: {
            async login() {
                await this.$store.dispatch('auth/login', this.loginForm)
                // console.log(this.loginForm)
                this.$router.push('/')
            },
            async register() {
                // auth.jsのregisterアクションを呼び出す
                await this.$store.dispatch('auth/register', this.registerForm)
                this.$router.push('/')
            },
            async logout() {
                await this.$store.dispatch('auth/logout')
                this.$router.push('/login')
            }
        },
    }
</script>
