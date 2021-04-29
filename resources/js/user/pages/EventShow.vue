<template>
    <div class="main-container">
        <div class="main-container__inner">
            <div v-show="loading">
                <Loader />
            </div>
            <div v-show="! loading">
                <div v-if="event" class="event-img">
                    <img class="event-img__file" :src="imgPath(event.image)">
                </div>
                <div class="event-info">
                    <div class="event-title">
                        {{ event.name }}
                    </div>
                    <div class="event-description">{{ event.description }}</div>
                    <ul>
                        <li>日程：{{ event.date }}</li>
                        <li>時間：{{ event.openTime }} 〜 {{ event.closeTime }}</li>
                        <li>場所：{{ event.place }}</li>
                    </ul>
                    <div class="event-price font-weight-bold">
                        <i class="fas fa-yen-sign"></i>
                        エントリー費：{{ event.price }} 円
                    </div>
                    <div class="entry-count">
                        <div class="number">
                            <font-awesome-icon style="min-width: 30px;" :icon="['fas', 'users']" />
                            {{ event.usersCount }}
                        </div>
                    </div>
                </div>

                <!-- 支払いボタン -->
                <div class="d-flex justify-content-center">
                    <button v-if="event.paymentButtonStatus === 1" class="button button__paypay" @click="payment">
                        PayPayで支払う
                    </button>
                    <button v-if="event.paymentButtonStatus === 2" class="button button__paypay">
                        振込先情報を表示
                    </button>
                    <button v-if="event.paymentButtonStatus === 3" class="button button__paid">
                        支払済
                    </button>
                    <button v-if="event.paymentButtonStatus === 4" class="mt-5 font-weight-bold">
                        無料イベントです🙆‍♂️
                    </button>
                    <button v-if="event.paymentButtonStatus === 5" class="button button__paid">
                        返金待ち
                    </button>
                </div>

                <!--エントリーボタン-->
                <div class="d-flex justify-content-center">
                    <a :href="routeToEntry" v-if="event.entryButtonStatus === 0" class="button button__join">
                        エントリーページへ
                    </a>
                    <button v-else-if="event.entryButtonStatus === 1" class="button button__joined">
                        エントリーをキャンセルする
                    </button>
                    <button v-else-if="event.entryButtonStatus === 2" class="button button__paid">
                        キャンセル待ち
                    </button>
                </div>

                <!-- <div class="d-flex justify-content-center" v-if="event.joined_by_user">
                    <button class="button button__paypay" @click="payment" v-show="!paid && !freeEvent">
                        PayPayで支払う
                    </button>
                    <span class="button button__paid" v-show="paid && !freeEvent">
                        支払済
                    </span>
                    <span class="button button__paid" v-show="!paid && freeEvent">
                        無料イベントにつき支払不要
                    </span>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button
                        class="button button__joined"
                        @click="onJoinClick()"
                        v-if="event.joined_by_user"
                    >
                        エントリーをやめる
                    </button>
                    <button
                        class="button button__join"
                        @click="onJoinClick()"
                        v-else
                    >
                        エントリーページへ
                    </button>
                </div> -->

                <!-- トップページへ戻る -->
                <div class="d-flex justify-content-center mt-5 font-weight-bold">
                    <a :href="routeToTop">トップページへ戻る</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { OK } from '../../util'
import Loader from '../../components/Loader.vue'

export default {
    components: {
        Loader
    },
    props: {
        propEvent: {
            type: Object,
            default: () => {}
        },
        routeToTop: {
            type: String,
            required: true
        },
        routeToEntry: {
            type: String,
            required: true
        },
        s3Path: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            event: this.propEvent,
            paid: false,
            freeEvent: false,
        }
    },
    methods: {
        // ログインチェック
        // onJoinClick () {
        //     if (! this.$store.getters['auth/check']) {
        //         alert('エントリー機能を使うにはログインしてください')
        //         return false
        //     }

        //     // エントリー済の場合と未エントリーの場合で条件分岐
        //     if (this.event.joined_by_user && this.evnet.date ) {
        //         this.$router.push(`/events/${this.id}/cancel`);
        //     } else {
        //         this.loading = true
        //         this.$router.push(`/events/${this.id}/entry`);
        //     }
        // },
        // Paypay決済ページへ遷移
        async payment () {
            this.loading = true
            const response = await axios.get(`/api/events/${this.event.id}/pay`);
            location.href = response.data;
        },
        // イベントサムネイルのURLを設定
        imgPath(url) {
            if (url == null) {
                url = '/img/noimage.png'
            } else {
                url = s3Path + url
            }
            return url;
        },
        // 支払い完了後の処理
        async fetchPaid () {
            console.log(this.event);
            this.loading = true
            const response = await axios.get(`/api/entry/${this.id}`);
            
            this.entry = response.data

            if (this.entry.paid == false) {
                this.paid = false
            } else if (this.entry.paid == true) {
                this.paid = true
            }
            this.loading = false
        },
    },
}
</script>
