<template>
    <div class="event-container">
        <div class="event-container__inner">
            <div v-show="loading">
                <Loader />
            </div>
            <div class="login-wrapper" v-if="! loading">
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
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="button__join">ログイン</button>
                        </div>
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
                        <input type="file" @change="onFileChange" name="fileinfo">
                        <output v-if="preview">
                            <img :src="preview" alt="" class="event-form-wrapper__img-preview">
                        </output>
                        <label for="name">名前</label>
                        <input type="text" id="name" v-model="registerForm.name">
                        <label for="email">メールアドレス</label>
                        <input type="text" id="email" v-model="registerForm.email">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" v-model="registerForm.password">
                        <label for="password_confirmation">パスワード確認用</label>
                        <input type="password" id="password-confirmation" v-model="registerForm.password_confirmation">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="button__join">新規登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import Loader from '../components/Loader.vue';

    export default {
        components: {
            Loader
        },
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
                },
                preview: null,
                image: null,
                loading: false,
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
            // apiStatus() {
            //     return this.$store.state.auth.apiStatus
            // },
            ...mapGetters({
                isLogin: 'auth/check'
            })
        },
        methods: {
            async login() {
                this.loading = true
                await this.$store.dispatch('auth/login', this.loginForm)

                this.loading = false
                if(this.apiStatus) {
                    this.$router.push('/')
                }
            },
            async register() {
                this.loading = true
                // アイコンの送信処理
                // console.log(this.registerForm.name)
                const formData = new FormData()
                formData.append('image', this.image)
                formData.append('name', this.registerForm.name)
                formData.append('email', this.registerForm.email)
                formData.append('password', this.registerForm.password)
                formData.append('password_confirmation', this.registerForm.password_confirmation)

                // const response = await axios.post('/api/register', formData)
                // その他のユーザー情報
                // await this.$store.dispatch('auth/register', this.registerForm)
                await this.$store.dispatch('auth/register', formData)

                this.loading = false
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
            },
            onFileChange(event) {
                // 何も選択されていなかったら処理中断
                if(event.target.files.length === 0) {
                    this.reset()
                    return false
                }
                // ファイルが画像ではなかったら処理中断
                if(! event.target.files[0].type.match('image.*')) {
                    this.reset()
                    return false
                }
                const reader = new FileReader()

                reader.onload = e => {
                    this.preview = e.target.result
                }

                reader.readAsDataURL(event.target.files[0])
                this.image = event.target.files[0]
            },
            reset() {
                this.preview = ''
                this.image = null
                this.$el.querySelector('input[type="file"]').value = null
            },
        },
        created() {
            this.clearError()
        },
    }
</script>
