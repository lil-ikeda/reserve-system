<template>
    <div>
        <div v-show="loading">
            <SendLoader />
        </div>
        <div class="event-container__inner" v-show="! loading">
            <div class="entry-headline">エントリー内容確認</div>
            <!--フォーム-->
            <form @submit.prevent="entry">
                <div class="event-info__entry">
                    <div class="entry-title">{{ event.name }}</div>

                    <ul class="entry-info">
                        <li>日程：{{ event.date }}</li>
                        <li>時間：{{ event.open_time }} 〜 {{ event.close_time }}</li>
                        <li>場所：{{ event.place }}</li>
                        <li class="event-price font-weight-bold">エントリー費：　{{ event.price }} 円</li>
                        <input type="hidden" name="price" v-model="price">
                    </ul>

                    <div v-show="! freeEvent">
                        <div class="select-payment">
                            <span>お支払方法を選択してください。</span>
                            <br>
                            <span class="select-payment__desc">（エントリーするだけでは支払完了しません。）</span>
                        </div>
                        <div class="inline-radio">
                            <div class="">
                                <input class="cursor-pointer" type="radio" name="payment_method" value="1" id="payment_method_bank" v-model="paymentMethod">
                                <label for="payment_method_bank">口座振込</label>
                            </div>
                            <div class="">
                                <input class="cursor-pointer" type="radio" name="payment_method" value="2" id="payment_method_paypay" v-model="paymentMethod">
                                <label for="payment_method_paypay">PayPay</label>
                            </div>
                        </div>
                        <div v-show="entryErrors" class="errors">
                            ※ お支払方法は必ず選択してください
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button
                        type="submit"
                        class="button button__join"
                        @click.prevent="onJoinClick">
                        <span>エントリー送信</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util'
    import SendLoader from '../components/SendLoader.vue'

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
                event: null,
                loading: false,
                entryErrors: false,
                freeEvent: false,
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
            async unjoin() {
                const response = await axios.delete(`/api/events/${this.id}/join`)

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.event.joined_by_user = false
            },
            async entry() {
                this.loading = true

                const response = await axios.put(`/api/events/${this.id}/join`, {
                    paymentMethod: this.paymentMethod,
                    price: this.event.price,
                });

                // バリデーションエラー
                if (response.status === UNPROCESSABLE_ENTITY) {
                    this.$store.commit('error/setCode', response.status)
                    this.entryErrors = true
                    this.loading = false
                    return false
                } else {
                    this.entryErrors = false
                }

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    this.loading = false
                    return false
                }

                this.$router.push({name: 'event.entry.confirm'});
            },
            imgPath(url) {
                if (url == null) {
                    url = '/img/noimage.png'
                } else {
                    url = 'https://sh-reserve.s3.ap-northeast-1.amazonaws.com' + url
                }
                return url;
            }
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
