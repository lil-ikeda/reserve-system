<template>
    <div class="event-container">
        <div class="event-container__inner">
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
                        <li>時間：{{ event.open_time }} 〜 {{ event.close_time }}</li>
                        <li>場所：{{ event.place }}</li>
                    </ul>
                    <div class="event-price font-weight-bold">エントリー費：{{ event.price }} 円</div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="button button__paypay" v-if="event.joined_by_user" @click="payment" v-show="! paid">
                        PayPayで支払う
                    </button>
                    <span class="button button__paid" v-if="event.joined_by_user" v-show="paid">
                        PayPayで支払済
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { OK } from '../util'
import Loader from '../components/Loader.vue'

export default {
    components: {
        Loader
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
            event: null,
            paid: false,
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
                this.loading = true
                this.$router.push(`/events/${this.id}/entry`);
            }
        },
        async payment () {
            this.loading = true

            const response = await axios.get(`/api/events/${this.id}/pay`);

            // 決済ページにリダイレクト
            location.href = response.data;
        },
        imgPath(url) {
            if (url == null) {
                url = '/img/noimage.png'
            } else {
                url = 'https://sh-reserve.s3.ap-northeast-1.amazonaws.com' + url
            }
            return url;
        },
        async fetchPaid () {
            const response = await axios.get(`/api/entry/${this.id}`);
            this.entry = response.data

            if (this.entry.paid == false) {
                this.paid = false
            } else if (this.entry.paid == true) {
                this.paid = true
            }
        }
    },
    watch: {
        $route: {
            async handler() {
                await this.fetchEvent();
                await this.fetchPaid();
            },
            immediate: true
        }
    },
}
</script>
