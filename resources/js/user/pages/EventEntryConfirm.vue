<template>
    <div class="main-container">
        <div class="main-container__inner">
            <div class="entry-headline">エントリー完了！！</div>
            <div class="event-info__entry">
                <div class="confirm-mail-icon">
                    <img src="/img/paper-plane.png">
                </div>
                <div>
                    登録メールアドレス宛に、エントリー内容確認用のメールを送信しております。
                    必ず期日までにエントリー費のお支払いを完了してください。
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div v-show="paymentMethod === '1'" class="button__paypay">
                <button @click="openModal">振込先情報を表示</button>
            </div>
            <div v-show="paymentMethod === '2'" class="button__paypay">
                <button @click="payment">今すぐPayPayで支払う</button>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5 font-weight-bold">
            <a :href="routeToTop">トップページへもどる</a>
        </div>

        <!-- 振込先情報 -->
        <modal @close="closeModal" v-if="modal">
            <p class="title">🏦 振込先情報</p>
            <p class="content">金融機関名：三菱東京UFJ銀行</p>
            <p class="content">支店名　　：渋谷支店</p>
            <p class="content">預金種別　：普通</p>
            <p class="content">口座番号　：1234567</p>
            <p class="content">口座名義　：タナカユウキ</p>
        </modal>
    </div>
</template>

<script>
// import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util'
    import Loader from '../../components/Loader.vue'
    import EventEntryConfirm from '../../pages/EventEntryConfirm.vue'
    import Modal from '../components/Modal'

    export default {
        components: {
            Loader,
            EventEntryConfirm,
            Modal
        },
        props: {
            routeToTop: {
                type: String,
                required: true
            },
            routeToPaypay: {
                type: String,
                required: true
            },
            eventId: {
                type: String
            },
            paymentMethod: {
                type: String
            }
        },
        data() {
            return {
                eventId: this.eventId,
                paymentMethod: this.paymentMethod,
                modal: false
            }
        },
        methods: {
            async payment () {
                this.loading = true
                const response = await axios.get(this.routeToPaypay);
                
                // 決済ページにリダイレクト
                if (response.status === 200) {
                    location.href = response.data;
                } else {
                    alert('URLの取得に失敗しました');
                }
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
