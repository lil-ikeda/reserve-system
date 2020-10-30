<template>
    <div class="event-container">
        <div class="event-container__inner">
            <div class="font-weight-bold">
                本当にキャンセルしますか？
            </div>

            <div class="">
                運営事務局にキャンセル希望メールを送信します。
            </div>

            <button @click="cancel">送信する</button>

        </div>
    </div>
</template>

<script>
    import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util'

    export default {
        props: {
            id: {
                type: String,
                required: true
            }
        },
        data() {
            return {
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
                // const response = await axios.post(`/api/events/${this.id}/cancel/sendmail`)

                // formの入力内容をformDataに
                // const formData = new FormData()
                // formData.append('payment_method', this.paymentMethod)
                //
                // const response = await axios.put(`/api/events/${this.id}/join`, formData)
                // console.log(response);
                //


                // if (response.status !== OK) {
                //     this.$store.commit('error/setCode', response.status)
                //     return false
                // }

                this.unjoin();

                this.$router.push({name: 'event.cancel.confirm'});


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
