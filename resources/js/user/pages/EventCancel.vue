<template>
<div>
    <div class="main-container" v-show="loading">
        <div class="main-container__inner">
            <Loader title="Loading..."/>
        </div>
    </div>
        
    <div class="main-container" v-show="!loading && !cancelRequested">
        <!-- キャンセル前 -->
        <div class="main-container__inner">
            <div class="entry-headline">
                本当にキャンセルしますか？
            </div>
            <div class="event-info__entry">
                <div class="">
                    スキルハック運営事務局にキャンセル希望メールを送信します。
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <span class="button__join">
                    <button @click="cancel">送信する</button>
                </span>
            </div>
        </div>
    </div>

    <!-- キャンセル後 -->
    <event-cancel-confirm 
        v-show="!loading && cancelRequested"
        :route-to-top="routeToTop"
    />
</div>
</template>

<script>
    // import {CREATED, OK, UNPROCESSABLE_ENTITY} from '../util';
    import Loader from "../../components/Loader";
    import EventCancelConfirm from "./EventCancelConfirm"

    export default {
        components: {
            Loader,
            EventCancelConfirm
        },
        props: {
            EntpointToCancelSendMail: {
                type: String,
                required: true
            },
            cancelRequested: {
                type: Boolean
            },
            routeToTop: {
                type: String
            }
        },
        data() {
            return {
                loading: false,
                cancelRequested: this.cancelRequested
            }
        },
        methods: {
            async cancel() {
                this.loading = true
                const response = await axios.post(this.EntpointToCancelSendMail)
                this.cancelRequested = true;
                this.loading = false

                // if (response.status !== OK) {
                //     this.$store.commit('error/setCode', response.status)
                //     return false
                // }


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
            // async unjoin() {
            //     const response = await axios.delete(`/api/events/${this.id}/join`)

            //     if (response.status !== OK) {
            //         this.$store.commit('error/setCode', response.status)
            //         return false
            //     }

            //     return true
                // this.event.joined_by_user = false
            // },
        },
    }
</script>
