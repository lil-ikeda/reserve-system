<template>
    <div class="event-container">
        <div class="event-container__inner">
            <div v-if="event" class="event-img">
                <img class="event-img__file" :src="`/storage/${event.image}`">
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
              @click.prevent="onJoinClick">
                <span v-if="event.joined_by_user">エントリーをやめる</span>
                <span v-else>エントリーする</span>
            </button>
            <div class="event-entry">
                <p>エントリーユーザー一覧</p>
                <div v-if="event.users.length > 0">
                    <ul 
                    v-for="user in event.users"
                    :key="user.name">
                        <li>{{ user.name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { OK } from '../util'

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
            console.log(this.event)
        },
        onJoinClick () {
            if (! this.$store.getters['auth/check']) {
                alert('エントリー機能を使うにはログインしてください')
                return false
            }

            if (this.event.joined_by_user) {
                this.unjoin()
            } else {
                this.join()
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
        },
        async unjoin() {
            const response = await axios.delete(`/api/events/${this.id}/join`)

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.event.joined_by_user = false
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
