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

        <!-- ログイン -->
        <div class="panel" v-show="tab === 1">
            <form @submit.prevent="login">
                <!-- エラーメッセージ -->
                <div v-if="loginErrors" class="errors">
                    <ul v-if="loginErrors.email">
                    <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="loginErrors.password">
                    <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
                <!-- 入力フォーム -->
                <label for="login-email">メールアドレス</label>
                <input type="text" id="login-email" v-model="loginForm.email">
                <label for="login-password">パスワード</label>
                <input type="password" id="login-password" v-model="loginForm.password">
                <button type="submit" class="btn-submit">ログイン</button>
            </form>
        </div>

        <!-- 新規登録 -->
        <div class="panel" v-show="tab === 2">
            <form @submit.prevent="register">
                <!-- エラーメッセージ -->
                <div v-if="registerErrors" class="errors">
                    <ul v-if="registerErrors.name">
                    <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="registerErrors.email">
                    <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="registerErrors.password">
                    <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
                <!-- 入力フォーム -->
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
import { mapState, mapGetters } from 'vuex'

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
        computed: {
            apiStatus() {
                return this.$store.state.auth.apiStatus
            },
            loginErrors() {
                return this.$store.state.auth.loginErrorMessages
            },
            registerErrors() {
                return this.$store.state.auth.registerErrorMessages
            },
            apiStatus() {
                return this.$store.state.auth.apiStatus
            },
            ...mapGetters({
                isLogin: 'auth/check'
            })
        },
        methods: {
            async login() {
                await this.$store.dispatch('auth/login', this.loginForm)
                if(this.apiStatus) {
                    this.$router.push('/')
                }
            },
            async register() {
                await this.$store.dispatch('auth/register', this.registerForm)
                if(this.apiStatus) {
                    this.$router.push('/')
                }
            },
            async logout() {
                await this.$store.dispatch('auth/logout')
                if(this.apiStatus) {
                    this.$router.push('/login')
                }
            },
            clearError() {
                this.$store.commit('auth/setLoginErrorMessages', null)
                this.$store.commit('auth/setRegisterErrorMessages', null)
            }
        },
        created() {
            this.clearError()
        },
    }
</script>
