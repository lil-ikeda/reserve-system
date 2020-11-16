<template>
    <div>
        <div v-show="loading">
            <Loader />
        </div>
        <div class="event-container__inner">
            <div class="entry-headline">本人確認用メール送信完了</div>
            <div class="event-info__entry">
                <div class="confirm-mail-icon">
                    <img src="/img/paper-plane.png">
                </div>
                <div>
                    メールに記載されているアドレスをクリックしてユーザー登録を完了させてください。
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5 font-weight-bold">
            <div class="">
                <button @click="backToTop">トップページへ戻る</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util'
    import Loader from '../components/Loader.vue'

    export default {
        components: {
            Loader
        },
        data() {
            return {
                loading: false,
            }
        },
        methods: {
            backToTop() {
                this.$router.push('/');
            },
        },
        watch: {
            $route: {
                // async handler() {
                //     await this.fetchEvent()
                // },
                // immediate: true
            }
        },

    }
</script>
