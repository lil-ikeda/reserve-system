<template>
    <div class="event-container__inner">
        <div class="headline-en">Register</div>
        <div class="headline-ja">新規登録</div>
        <div class="login-wrapper">
            <div class="panel">
                <form :action="registerRoute" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="_method" value="POST">
                    <!-- 入力フォーム -->
                    <output v-if="preview" class="login-wrapper__img-wrapper">
                        <img :src="preview" alt="" class="login-wrapper__img-preview">
                    </output>
                    <input type="file" @change="onFileChange" name="file">
                    <label for="name">名前</label>
                    <input type="text" id="name" name="name">
                    <label for="email">メールアドレス</label>
                    <input type="text" id="email" name="email">
                    <label for="phone">電話番号</label>
                    <input type="number" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    <label for="circle_id">出身サークル</label>
                    <select name="circle_id" id="circle_id" class="register-select-form">
                        <option value="">選択してください</option>
                        <option v-for="(circle, index) in circles" :key="index" :value="circle.id">{{ circle.name }}</option>
                    </select>
                    <label for="birthday">生年月日</label>
                    <input type="date" id="birthday" name="birthday">
                    <label for="sex">性別</label>
                    <select name="sex" id="sex" class="register-select-form">
                        <option value="">選択してください</option>
                        <option value="1">男性</option>
                        <option value="2">女性</option>
                        <option value="0">回答しない</option>
                    </select>
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password">
                    <label for="password_confirmation">パスワード確認用</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="button__join">新規登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
// import { mapState, mapGetters } from 'vuex';
import Loader from '../../components/Loader.vue';

    export default {
        components: {
            Loader
        },
        props: {
            propLoginRoute: {
                type: String
            },
            propRegisterRoute: {
                type: String
            },
            csrfToken: {
                type: String
            },
            propCircles: {
                type: Array
            },
        },
        data() {
            return {
                preview: null,
                image: null,
                loading: false,
                registerRoute: this.propRegisterRoute,
                loginUrl: this.propLoginRoute,
                circles: this.propCircles,
            }
        },
        methods: {
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
