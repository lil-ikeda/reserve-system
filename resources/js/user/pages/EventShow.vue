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
                    <button v-if="event.paymentButtonStatus === 2" class="button button__paypay" @click="openModal">
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

                <!-- 振込先情報表示用モーダル -->
                <modal @close="closeModal" v-if="modal">
                    <p class="title">🏦 振込先情報</p>
                    <p class="content">金融機関名：三菱東京UFJ銀行</p>
                    <p class="content">支店名　　：渋谷支店</p>
                    <p class="content">預金種別　：普通</p>
                    <p class="content">口座番号　：1234567</p>
                    <p class="content">口座名義　：タナカユウキ</p>
                </modal>

                <!--エントリーボタン-->
                <div class="d-flex justify-content-center">
                    <a :href="routeToEntry" v-if="event.entryButtonStatus === 0" class="button button__join">
                        エントリーページへ
                    </a>
                    <a :href="routeToCancel" v-else-if="event.entryButtonStatus === 1" class="button button__joined">
                        エントリーをキャンセルする
                    </a>
                    <button v-else-if="event.entryButtonStatus === 2" class="button button__paid">
                        キャンセル待ち
                    </button>
                </div>

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
import Modal from '../components/Modal'

export default {
    components: {
        Loader,
        Modal
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
        routeToCancel: {
            type: String,
            required: true
        },
        endpointToPaypay: {
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
            modal: false
        }
    },
    methods: {
        // Paypay決済ページへ遷移
        async payment () {
            this.loading = true
            const response = await axios.get(this.endpointToPaypay);
            if (response.status === 200) {
                location.href = response.data;
            } else {
                alert('URLの取得に失敗しました');
            }
        },
        // イベントサムネイルのURLを設定
        imgPath(url) {
            if (url == null) {
                url = '/img/noimage.png'
            } else {
                url = this.s3Path + url
            }
            return url;
        },
        openModal() {
            this.modal = true
        },
        closeModal() {
            this.modal = false
        }
    },
}
</script>
