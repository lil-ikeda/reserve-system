<template>
    <div class="event-container">
        <div class="headline-en">Events</div>
        <div class="headline-ja">すべてのイベント</div>
        <div v-show="loading">
            <Loader />
        </div>
        <div v-show="! loading" class="cards-box" v-for="event in events">
            <!-- イベントカード -->
            <router-link class="text-decoration-none font-black" v-bind:to="{ name: 'event.show', params: {id: event.id} }">
                <div class="event-card">
                    <div class="event-card__left">
                        <div class="event-card__left--img">
                            <img :src="imgPath(event.image)">
                        </div>
                    </div>
                    <div class="event-card__right">
                        <p class="event-card__right--title">{{ event.name }}</p>
                        <div class="event-card__right--info">
                            <ul>
                                <li>
                                    <font-awesome-icon style="min-width: 30px;" :icon="['fas', 'calendar-alt']" />
                                    {{ event.date }}
                                </li>
                                <li>
                                    <font-awesome-icon style="min-width: 30px;" :icon="['fas', 'clock']" />
                                    {{ event.open_time }} - {{ event.close_time }}
                                </li>
                                <li>
                                    <font-awesome-icon style="min-width: 30px;" :icon="['fas', 'map-marker-alt']" />
                                    {{ event.place }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import Loader from '../components/Loader.vue'

    export default {
        // props: {
        //     item: {
        //         type: Object,
        //         required: true
        //     }
        // },
        components: {
            Loader,
        },
        data: function() {
            return {
                loading: true,
                events: [],
            }
        },
        methods: {
            getEvents() {
                axios.get('/api/events')
                    .then((res) => {
                        this.events = res.data;
                    });
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
        mounted() {
            this.getEvents();
            this.loading = false;
        }
    }
</script>
