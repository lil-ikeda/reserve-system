<template>
    <div>
        <div v-show="loading" class="main-container">
            <div class="main-container__inner">
                <Loader />
            </div>
        </div>

        <!-- 未エントリー -->
        <div v-show="!loading && !entered" class="main-container">
            <div class="main-container__inner">
                <div class="entry-headline">エントリーしますか？</div>
                <div class="event-info__entry">
                    <div class="entry-title">{{ event.name }}</div>
                    <ul class="entry-info">
                        <li>日程：{{ event.date }}</li>
                        <li>時間：{{ event.openTime }} 〜 {{ event.closeTime }}</li>
                        <li>場所：{{ event.place }}</li>
                        <li>エントリー費： {{ event.price }} 円</li>
                    </ul>
                    <div v-if="!freeEvent">
                        <div class="select-payment">
                            <span>お支払方法を選択してください。</span>
                            <br>
                            <span class="select-payment__desc">（エントリーするだけでは支払完了しません。）</span>
                        </div>
                        <div class="inline-radio">
                            <div class="">
                                <input class="cursor-pointer" type="radio" name="payment_method"
                                    :value="paymentMethodPaypay" id="payment_method_paypay" v-model="paymentMethod"
                                >
                                <label for="payment_method_paypay">PayPay</label>
                            </div>
                            <div class="">
                                <input class="cursor-pointer" type="radio" name="payment_method"
                                    :value="paymentMethodBank" id="payment_method_bank" v-model="paymentMethod"
                                >
                                <label for="payment_method_bank">口座振込</label>
                            </div>
                        </div>
                        <div v-show="entryErrors" class="errors">
                            ※ お支払方法は必ず選択してください
                        </div>
                    </div>
                </div>
                <div @click="entry" class="d-flex justify-content-center">
                    <button class="button button__join">
                        <span>エントリーする</span>
                    </button>
                </div>

                <div class="d-flex justify-content-center mt-5 font-weight-bold">
                    <a :href="routeToBack">もどる</a>
                </div>
            </div>
        </div>

        <!-- エントリー後 -->
        <event-entry-confirm
            v-show="!loading && entered"
            :route-to-paypay="routeToPaypay"
            :route-to-top="routeToTop"
            :event-id="event.id"
            :paymentMethod="paymentMethod"
        />
    </div>
</template>

<script>
    // import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util'
    import Loader from '../../components/Loader.vue'
    import EventEntryConfirm from './EventEntryConfirm.vue'

    export default {
        components: {
            Loader,
                EventEntryConfirm
        },
        props: {
            propEvent: {
                type: Object,
                default: () => {}
            },
            freeEvent: {
                type: Boolean
            },
            routeToTop: {
                type: String,
                required: true
            },
            routeToBack: {
                type: String,
                required: true
            },
            routeToEntry: {
                type: String,
                required: true
            },
            routeToPaypay: {
                type: String,
                required: true
            },
            paymentMethodPaypay: {
                type: String,
                required: true
            },
            paymentMethodBank: {
                type: String,
                required: true
            },
            entered: {
                type: Boolean
            }
        },
        data() {
            return {
                event: this.propEvent,
                loading: false,
                entryErrors: false,
                paymentMethod: this.paymentMethodPaypay,
                entered: false
            }
        },
        methods: {
            async unjoin() {
                const response = await axios.delete(`/api/events/${this.id}/join`)

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.event.joined_by_user = false
            },
            entry() {
                this.loading = true
                const data = {
                    _token: this.csrfToken,
                    payment_method: this.paymentMethod,
                    price: this.event.price,
                    free_event: this.freeEvent
                }
                axios.post(this.routeToEntry, data)
                    .then(response => {
                        if (response.status === 200) {
                            this.loading = false;
                            this.entered = true;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        alert('サーバーエラー発生しました。');
                    })

                // const response = await axios.post(this.routeToEntry, {
                //     _token: this.csrfToken,
                //     payment_method: this.paymentMethod,
                //     price: this.event.price,
                //     free_event: this.freeEvent
                // });

                console.log(response);

                // const response = await axios.put(`/api/events/${this.event.id}/join`, {
                //     paymentMethod: this.paymentMethod,
                //     price: this.event.price,
                // });

                // バリデーションエラー
                // if (response.status === UNPROCESSABLE_ENTITY) {
                //     this.$store.commit('error/setCode', response.status)
                //     this.entryErrors = true
                //     this.loading = false
                //     return false
                // } else {
                //     this.entryErrors = false
                // }

                // if (response.status !== OK) {
                //     this.$store.commit('error/setCode', response.status)
                //     this.loading = false
                //     return false
                // }

                // this.$router.push({name: 'event.entry.confirm'});
            },
            async payment () {
                this.loading = true
                const response = await axios.get(this.routeToPaypay);

                // 決済ページにリダイレクト
                location.href = response.data;
            },
        },
    }
</script>
