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
            <div class="button__paypay">
                <button @click="payment">今すぐPayPayで支払う</button>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-5 font-weight-bold">
            <a :href="routeToTop">トップページへもどる</a>
        </div>
    </div>
</template>

<script>
// import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util'
    import Loader from '../../components/Loader.vue'
    import EventEntryConfirm from '../../pages/EventEntryConfirm.vue'

    export default {
        components: {
            Loader,
                EventEntryConfirm
        },
        props: {
            routeToTop: {
                type: String,
                required: true
            },
            eventId: {
                type: String
            }
        },
        data() {
            return {
                eventId: this.eventId
            }
        },
        methods: {
            async payment () {
                this.loading = true
                const response = await axios.get(`/api/events/${this.eventId}/pay`);

                // 決済ページにリダイレクト
                location.href = response.data;
            },
        },
    }
</script>
