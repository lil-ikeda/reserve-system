<template>
    <div class="event-container">
        <div class="event-container__inner">
<!--            <div v-if="event" class="event-img">-->
<!--                <img class="event-img__file" :src="imgPath(event.image)">-->
<!--            </div>-->
            <div class="font-weight-bold">
                エントリー内容確認
            </div>
            <div class="event-title">
                {{ event.name }}
            </div>
<!--            <div class="event-description">{{ event.description }}</div>-->
            <div class="event-info">
                <ul>
                    <li>日程：{{ event.date }}</li>
                    <li>時間：{{ event.open_time }} 〜 {{ event.close_time }}</li>
                    <li>場所：{{ event.place }}</li>
                    <li class="event-sales font-weight-bold">エントリー：　{{ event.price }} 円</li>
                </ul>
            </div>

            <div class="">
                お支払い方法を選択してください。
                <br>
                （エントリーするだけでは支払完了しません。）
            </div>

            <form @submit.prevent="entry">
                <div class="">
                    <input type="radio" name="payment_method" value="1" id="payment_method_bank" v-model="paymentMethod">
                    <label for="payment_method_bank">口座振込</label>
                    <input type="radio" name="payment_method" value="2" id="payment_method_paypay" v-model="paymentMethod">
                    <label for="payment_method_paypay">PayPay</label>
                </div>

                <button
                    type="submit"
                    class="button button__join"
                    @click.prevent="onJoinClick">
                    <span>エントリーする</span>
                </button>
            </form>
<!--            <router-link-->
<!--                v-bind:to="{name: 'event.entry'}"-->
<!--                class="button button__join">-->
                <!--              :class="{ 'button button__joined' : event.joined_by_user }"-->
                <!--              @click.prevent="onJoinClick"-->
                <!--            >-->
<!--                <span v-if="event.joined_by_user"></span>-->
<!--                <span v-else>Paypayで支払う</span>-->
<!--            </router-link>-->
            <!--            <div class="event-entry">-->
            <!--                <p>エントリーユーザー一覧</p>-->
            <!--                <div v-if="event.users.length > 0">-->
            <!--                    <ul-->
            <!--                    v-for="user in event.users"-->
            <!--                    :key="user.name">-->
            <!--                        <li>{{ user.name }}</li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--                <div v-else>-->
            <!--                    <p>エントリー中のユーザーがいません</p>-->
            <!--                </div>-->
            <!--            </div>-->
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
            async fetchEvent() {
                const response = await axios.get(`/api/events/${this.id}`);

                if(response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.event = response.data
            },
            async login() {
                await this.$store.dispatch('auth/login', this.loginForm)

                if(this.apiStatus) {
                    this.$router.push('/')
                }
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
            async join() {
                const response = await axios.put(`/api/events/${this.id}/join`)
                // エラー時はエラーメッセージ表示
                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }
                this.event.joined_by_user = true
                // エントリーしたユーザーを非同期で画面に反映
                // this.fetchEvent();
            },
            async unjoin() {
                const response = await axios.delete(`/api/events/${this.id}/join`)

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.event.joined_by_user = false
                // エントリーをやめたユーザーを非同期で画面に反映
                this.fetchEvent();
            },
            async entry() {
                // formの入力内容をformDataに
                const formData = new FormData()
                formData.append('payment_method', this.paymentMethod)

                const response = await axios.put(`/api/events/${this.id}/join`, formData)
                console.log(response);

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.$router.push({name: 'event.entry.confirm'});


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
