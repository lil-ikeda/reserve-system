<template>
    <div class="event-container__inner">
        <div class="headline-en">Profile</div>
        <div class="headline-ja">プロフィール</div>
        <div class="login-wrapper">
            <div v-show="loading">
                <Loader title="Loading..."/>
            </div>
            <div class="panel">
                <form :action="updateRoute" method="POST" enctype="multipart/form-data" v-show="!loading">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="id" :value="authUser.id">
                    
                    <!-- 入力フォーム -->
                    <output v-if="preview" class="login-wrapper__img-wrapper">
                        <label for="file"><img :src="preview" alt="" class="login-wrapper__img-preview"></label>
                    </output>
                    <label v-else for="file" class="login-wrapper__img-default">
                        <span class="icon">＋</span>
                    </label>
                    <input type="file" @change="onFileChange" name="file" id="file" class="d-none">
                    <div class="invalid-feedback d-block" v-if="propErrors.file">
                        {{ propErrors.file[0] }}
                    </div>

                    <div class="form-group">
                        <label for="name">名前</label>
                        <input type="text" id="name" name="name" v-model="olds.name" placeholder="田中太郎">
                        <div class="invalid-feedback d-block" v-if="propErrors.name">
                            {{ propErrors.name[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="text" id="email" name="email" v-model="olds.email" placeholder="tanaka@example.com">
                        <div class="invalid-feedback d-block" v-if="propErrors.email">
                            {{ propErrors.email[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">電話番号</label>
                        <input type="number" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" v-model="olds.phone" placeholder="090-1234-5678">
                        <div class="invalid-feedback d-block" v-if="propErrors.phone">
                            {{ propErrors.phone[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="circle_id">出身サークル</label>
                        <select name="circle_id" id="circle_id" class="register-select-form" v-model="olds.circle_id">
                            <option value="">選択してください</option>
                            <option v-for="(circle, index) in circles" :key="index" :value="circle.id">{{ circle.name }}</option>
                        </select>
                        <div class="invalid-feedback d-block" v-if="propErrors.circle_id">
                            {{ propErrors.circle_id[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthday">生年月日</label>
                        <input type="date" id="birthday" name="birthday" class="register-select-form" v-model="olds.birthday">
                        <div class="invalid-feedback d-block" v-if="propErrors.birthday">
                            {{ propErrors.birthday[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex">性別</label>
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
                    <div class="d-flex justify-content-center" @click="submit">
                        <button type="submit" class="button__join">更新する</button>
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
            updateRoute: {
                type: String
            },
            csrfToken: {
                type: String
            },
            propCircles: {
                type: Array
            },
            propAuthUser: {
                type: Object
            },
            propErrors: {
                type: [Object, Array]
            },
            propOld: {
                type: [Object, Array]
            },
            s3Path: {
                type: String
            }
        },
        data() {
            return {
                preview: null,
                image: null,
                loading: false,
                authUser: this.propAuthUser,
                olds: this.propOld,
                circles: this.propCircles
            }
        },
        mounted() {
            // セレクトボックスの初期値セット
            if (this.olds.length === 0) {
                this.olds = {
                    avatar: this.fetchAvatar(this.authUser.avatar),
                    name: this.authUser.name,
                    email: this.authUser.email,
                    phone: this.authUser.phone,
                    circle_id: this.authUser.circle_id,
                    birthday: this.authUser.birthday,
                    sex: this.authUser.sex,
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
            fetchAvatar(avatar) {
                // 何も選択されていなかったら処理中断
                if(avatar === 0) {
                    this.reset()
                    return false
                }

                this.preview = this.s3Path + avatar
                this.image = this.s3Path + avatar
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
        },
    }
</script>
