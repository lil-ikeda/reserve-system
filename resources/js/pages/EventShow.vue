<template>
    <div class="event-container">
        <div class="event-container__inner">
            <div v-show="loading">
                <Loader />
            </div>
            <div v-if="event" class="event-img">
                <img class="event-img__file" :src="imgPath(event.image)">
            </div>
            <div class="event-title">
                {{ event.name }}
            </div>
            <div class="event-description">{{ event.description }}</div>
            <div class="event-sales">{{ event.price }} 円</div>
            <div class="event-info">
                <ul>
                    <li>日程：{{ event.date }}</li>
                    <li>時間：{{ event.open_time }} 〜 {{ event.close_time }}</li>
                    <li>場所：{{ event.place }}</li>
                </ul>
            </div>
            <button
                class="button button__join"
                :class="{ 'button button__joined' : event.joined_by_user }"
                @click="onJoinClick()"
            >
                <span v-if="event.joined_by_user">
                    エントリーをやめる
                </span>
                <span v-else>
                    エントリーページへ
                </span>
            </button>

            <button class="button button__paypay" v-if="event.joined_by_user" @click="linkToPayment">
                PayPayで支払う
            </button>
        </div>
    </div>
</template>

<script>
import { OK } from '../util'
import { Loader } from '../components/Loader.vue'

export default {
    components: {
        Loader
    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            loading: true,
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
            this.loading = false
        },
        onJoinClick () {
            // ログインチェック
            if (! this.$store.getters['auth/check']) {
                alert('エントリー機能を使うにはログインしてください')
                return false
            }

            if (this.event.joined_by_user) {
                this.$router.push(`/events/${this.id}/cancel`);
            } else {
                this.$router.push(`/events/${this.id}/entry`);
            }
        },
        linkToPayment () {
            this.$router.push(`/events/${this.id}/payment/paypay`);
        },
        // async join() {
        //     const response = await axios.put(`/api/events/${this.id}/join`)
        //     // エラー時はエラーメッセージ表示
        //     if (response.status !== OK) {
        //         this.$store.commit('error/setCode', response.status)
        //         return false
        //     }
        //     // エントリー済みフラグをtrueに
        //     this.event.joined_by_user = true
        //     // エントリーページに繊維
        //     this.$router.push(`/events/${this.id}/entry`)
        // },
        // async unjoin() {
        //     const response = await axios.delete(`/api/events/${this.id}/join`)
        //
        //     if (response.status !== OK) {
        //         this.$store.commit('error/setCode', response.status)
        //         return false
        //     }
        //
        //     this.event.joined_by_user = false
        // },
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
