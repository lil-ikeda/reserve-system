<template>
    <div>
        <div class="headline-en">Events</div>
        <div class="headline-ja">開催予定のイベント</div>
        <div class="cards-box" v-for="event in events">
            <!-- イベントカード -->
            <a class="text-decoration-none font-black" :href="event.url">
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
                                    {{ event.openTime }} 〜 {{ event.closeTime }}
                                </li>
                                <li>
                                    <font-awesome-icon style="min-width: 30px;" :icon="['fas', 'map-marker-alt']" />
                                    {{ event.place }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    import Loader from '../../components/Loader.vue'

    export default {
        props: {
            propEvents: {
                type: Array,
                default: () => {}
            },
            s3Path: {
                type: String,
                required: true
            }
        },
        components: {
            Loader,
        },
        data: function() {
            return {
                loading: false,
                events: this.propEvents,
            }
        },
        methods: {
            getEvents() {
                axios.get('/api/events')
                    .then((res) => {
                        this.events = res.data;
                    });
                    console.log('OK');
            },
            imgPath(url) {
                if (url == null) {
                    url = '/img/noimage.png'
                } else {
                    url = s3Path + url
                }
                return url;
            }
        },
        mounted() {
            // this.getEvents();
            this.loading = false;
        }
    }
</script>
