<template>
    <div class="event-container">
        <div class="cards-box" v-for="event in events">
            <!-- イベントカード -->
            <router-link class="text-decoration-none font-black" v-bind:to="{ name: 'event.show', params: {id: event.id} }">
                <div class="event-card">
                    <div class="event-card__left">
                        <div class="event-card__left--img">
                            <img :src="`/storage/${event.image}`">
                        </div>
                    </div>
                    <div class="event-card__right">
                        <p class="event-card__right--title">{{ event.name }}</p>
                        <div class="event-card__right--info">
                            <ul>
                                <li>日程：{{ event.date }}</li>
                                <li>時間：{{ event.open_time }} - {{ event.close_time }}</li>
                                <li>場所：{{ event.place }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        // props: {
        //     item: {
        //         type: Object,
        //         required: true
        //     }
        // },
        data: function() {
            return {
                events: []
            }
        },
        methods: {
            getEvents() {
                axios.get('/api/events')
                    .then((res) => {
                        this.events = res.data;
                    });
            }
        },
        mounted() {
            this.getEvents();
        }
    }
</script>