<template>
    <div>
        <div v-show="loading">
            <Loader />
        </div>
        <div v-show="! loading">
            <div class="event-container__inner">
                <div class="entry-headline">エントリー完了！！</div>
                <div class="event-info__entry">
                    <div class="confirm-mail-icon">
                        <img src="/img/paper-plane.png">
                    </div>
                    <div>
                        登録メールアドレス宛に、エントリー内容確認用のメールを送信しました。
                        必ず期日までにエントリー費のお支払いを完了してください。
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="button__paypay">
                    <button @click="payment">PayPayで支払う</button>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-5 font-weight-bold">
                <div class="">
                    <button @click="backToTop">トップページへ戻る</button>
                </div>
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
        props: {
            id: {
                type: [String],
                required: true
            }
        },
        data() {
            return {
                loading: false,
                event: null
            }
        },
        methods: {
            async fetchEvent() {
                const response = await axios.get(`/api/events/${this.id}`);

                if(response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.event = response.data
            },
            async login() {
                await this.$store.dispatch('auth/login', this.loginForm)

                if(this.apiStatus) {
                    this.$router.push('/')
                }
            },
            onJoinClick () {
                if (! this.$store.getters['auth/check']) {
                    alert('エントリー機能を使うにはログインしてください')
                    return false
                }

                if (this.event.joined_by_user) {
                    this.unjoin()
                } else {
                    this.entry()
                }
            },
            async join() {
                const response = await axios.put(`/api/events/${this.id}/join`)
                // エラー時はエラーメッセージ表示
                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }
                this.event.joined_by_user = true
                // エントリーしたユーザーを非同期で画面に反映
                // this.fetchEvent();
            },
            async unjoin() {
                const response = await axios.delete(`/api/events/${this.id}/join`)

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.event.joined_by_user = false
                // エントリーをやめたユーザーを非同期で画面に反映
                this.fetchEvent();
            },
            async entry() {
                // formの入力内容をformDataに
                const formData = new FormData()
                formData.append('payment_method', this.paymentMethod)

                const response = await axios.put(`/api/events/${this.id}/join`, formData)

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.$router.push({name: 'event.entry.confirm'});


                // this.loading = false
                // バリデーションエラーハンドリング
                // if(response.status === UNPROCESSABLE_ENTITY) {
                //     this.errors = response.data.errors
                //     return false
                // }
                // this.reset()
                // // イベント作成成功時
                // if(response.status !== CREATED) {
                //     this.$store.commit('error/setCode', response.status)
                //     return false
                // }
                // this.$store.commit('message/setContent', {
                //     content: `${this.event.name}へのエントリーが完了しました！`,
                //     timeout: 6000
                // })

            },
            imgPath(url) {
                if (url == null) {
                    url = '/img/noimage.png'
                } else {
                    url = 'https://sh-reserve.s3.ap-northeast-1.amazonaws.com' + url
                }
                return url;
            },
            backToTop() {
                this.$router.push('/');
            },
            // async linkToPayment() {
            //     // this.$router.push(`/events/${this.id}/payment/paypay`)
            //     const response = await axios.put(`/api/events/${this.id}/join`)
            // },
            async payment () {
                this.loading = true

                const response = await axios.get(`/api/events/${this.id}/pay`);

                // 決済ページにリダイレクト
                location.href = response.data;
            },
        },
        watch: {
            $route: {
                async handler() {
                    await this.fetchEvent()
                },
                immediate: true
            }
        },

    }
</script>
