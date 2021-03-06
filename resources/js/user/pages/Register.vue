<template>
    <div class="event-container__inner">
        <div class="headline-en">Register</div>
        <div class="headline-ja">新規登録</div>
        <div class="login-wrapper">
            <div v-show="loading">
                <Loader title="Loading..."/>
            </div>
            <div class="panel">
                <form :action="registerRoute" method="POST" enctype="multipart/form-data" v-show="!loading">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="_method" value="POST">
                    
                    <!-- 入力フォーム -->
                    <output v-if="preview" class="login-wrapper__img-wrapper">
                        <img :src="preview" alt="" class="login-wrapper__img-preview">
                    </output>
                    <label v-else for="file" class="login-wrapper__img-default">
                        <span class="icon">＋</span>
                    </label>

                    <input type="file" @change="onFileChange" name="file" id="file" class="d-none">
                    <div class="invalid-feedback d-block" v-if="propErrors.file">
                        {{ propErrors.file[0] }}
                    </div>

                    <div class="form-group">
                        <label for="name">名前 <span class="badge badge-danger">必須</span></label>
                        <input type="text" id="name" name="name" v-model="olds.name" placeholder="田中太郎">
                        <div class="invalid-feedback d-block" v-if="propErrors.name">
                            {{ propErrors.name[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス <span class="badge badge-danger">必須</span></label>
                        <input type="text" id="email" name="email" v-model="olds.email" placeholder="tanaka@example.com">
                        <div class="invalid-feedback d-block" v-if="propErrors.email">
                            {{ propErrors.email[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">電話番号 <span class="badge badge-danger">必須</span></label>
                        <input type="number" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" v-model="olds.phone" placeholder="090-1234-5678">
                        <div class="invalid-feedback d-block" v-if="propErrors.phone">
                            {{ propErrors.phone[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="circle_id">出身サークル <span class="badge badge-danger">必須</span></label>
                        <select name="circle_id" id="circle_id" class="register-select-form" v-model="olds.circle_id">
                            <option value="">選択してください</option>
                            <option v-for="(circle, index) in circles" :key="index" :value="circle.id">{{ circle.name }}</option>
                        </select>
                        <div class="invalid-feedback d-block" v-if="propErrors.circle_id">
                            {{ propErrors.circle_id[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthday">生年月日 <span class="badge badge-danger">必須</span></label>
                        <input type="date" id="birthday" name="birthday" class="register-select-form" v-model="olds.birthday">
                        <div class="invalid-feedback d-block" v-if="propErrors.birthday">
                            {{ propErrors.birthday[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex">性別 <span class="badge badge-danger">必須</span></label>
                        <select name="sex" id="sex" class="register-select-form" v-model="olds.sex">
                            <option value="" selected>選択してください</option>
                            <option value="1">男性</option>
                            <option value="2">女性</option>
                            <option value="0">回答しない</option>
                        </select>
                        <div class="invalid-feedback d-block" v-if="propErrors.sex">
                            {{ propErrors.sex[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" style="margin-bottom: 0;">パスワード <span class="badge badge-danger">必須</span></label>
                        <span class="text-black-50 d-block"> ※8文字以上の半角英数字・記号</span>
                        <input type="password" id="password" name="password" v-model="olds.password" placeholder="password" autocomplete="off">
                        <div class="invalid-feedback d-block" v-if="propErrors.password">
                            {{ propErrors.password[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">パスワード確認用 <span class="badge badge-danger">必須</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" v-model="olds.password_confirmation" placeholder="password" autocomplete="off">
                        <div class="invalid-feedback d-block" v-if="propErrors.password_confirmation">
                            {{ propErrors.password_confirmation[0] }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-center" @click="submit">
                        <button type="submit" class="button__join">新規登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
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
            propErrors: {
                type: [Object, Array]
            },
            propOld: {
                type: [Object, Array]
            }
        },
        data() {
            return {
                preview: null,
                image: null,
                loading: false,
                registerRoute: this.propRegisterRoute,
                loginUrl: this.propLoginRoute,
                circles: this.propCircles,
                olds: this.propOld,
            }
        },
        mounted() {
            // セレクトボックスの初期値セット
            if (this.olds.length === 0) {
                this.olds = {
                    birthday: this.formatDate(new Date()),
                    sex: '',
                    circle_id: ''
                }
            }
        },
        methods: {
            async logout() {
                await this.$store.dispatch('auth/logout')
                if(this.apiStatus) {
                    this.$router.push('/login')
                }
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
            submit() {
                this.loading = true;
            },
            // 日付をYYYY-MM-DDの書式で返すメソッド
            formatDate(date) {
                var y = date.getFullYear();
                var m = ('00' + (date.getMonth()+1)).slice(-2);
                var d = ('00' + date.getDate()).slice(-2);
                return (y + '-' + m + '-' + d);
            }
        },
    }
</script>
