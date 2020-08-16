<template>
    <div class="event-container">
        <div class="event-container__inner">
            <div v-if="event" class="event-img">
                <img class="event-img__file" :src="`/storage/${event.image}`">
                <!-- <div class="event-img__file"></div> -->
            </div>
            <div class="event-title">
                <!-- <p>Reknot</p> -->
                <!-- <input type="text" readonly id="id" v-model="event.name"> -->
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
            <div class="event-entry">
                <p>エントリーユーザー一覧</p>
                <ul>
                    <li>ゆってぃ</li>
                    <li>タスク</li>
                    <li>せいやま</li>
                </ul>
            </div>
            <button class="btn-danger" v-on:click="deleteEvent(event.id)">削除する</button>
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
            // console.log(this.id)
            const response = await axios.get(`/api/events/${this.id}`);

            if(response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.event = response.data
        },
        // getEvent() {
        //     axios.get('/api/events/' + this.id)
        //         .then((res) => {
        //             this.event = res.data;
        //         });
        // },
        deleteEvent(id) {
            axios.delete('/api/events/' + id, this.event)
                .then((res) => {
                    this.$router.push({name: 'event.list'});
                });
            this.$store.commit('message/setContent', {
                    content: 'イベントが削除されました！',
                    timeout: 6000
                })
        }
    },
    watch: {
        $route: {
            async handler() {
                await this.fetchEvent()
            },
            immediate: true
        }
    }
    // mounted() {
    //     this.getEvent();
    // }
}
</script>