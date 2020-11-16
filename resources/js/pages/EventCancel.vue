<template>
    <div>
        <div v-show="loading">
            <SendLoader />
        </div>
        <div class="event-container__inner" v-show="! loading">
            <div class="entry-headline">
                本当にキャンセルしますか？
            </div>
            <div class="event-info__entry">
                <div class="">
                    運営事務局にキャンセル希望メールを送信します。
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <span class="button__join">
                    <button @click="cancel">送信する</button>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util';
    import SendLoader from "../components/SendLoader";

    export default {
        components: {
            SendLoader
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

            async login() {
                await this.$store.dispatch('auth/login', this.loginForm)

                if(this.apiStatus) {
                    this.$router.push('/')
                }
            },

            async cancel() {
                this.loading = true
                const response = await axios.post(`/api/events/${this.id}/cancel/sendmail`, {id: this.id})

                // formの入力内容をformDataに
                // const formData = new FormData()
                // formData.append('payment_method', this.paymentMethod)
                //
                // const response = await axios.put(`/api/events/${this.id}/join`, formData)
                // console.log(response);
                //


                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.loading = false
                this.$router.push({name: 'event.cancel.confirm'});

                // const result = this.unjoin();
                // if (result === true) {
                //     this.$router.push({name: 'event.cancel.confirm'});
                // }


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
            async unjoin() {
                const response = await axios.delete(`/api/events/${this.id}/join`)

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                return true
                // this.event.joined_by_user = false
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
