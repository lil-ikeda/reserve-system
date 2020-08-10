<template>
    <div class="event-container">
      <div class="event-container__inner">
          <div class="event-img">
              <div class="event-img__file"></div>
          </div>
          <div class="event-title">
              <!-- <p>Reknot</p> -->
              <input type="text" readonly id="id" v-model="event.name">
          </div>
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
    export default {
        props: {
            eventId: String
        },
        data: function() {
            return {
                event: {}
            }
        },
        methods: {
            getEvent() {
                axios.get('/api/events/' + this.eventId)
                    .then((res) => {
                        this.event = res.data;
                    });
            },
            deleteEvent(id) {
                axios.delete('/api/events/' + id, this.event)
                    .then((res) => {
                        this.$router.push({name: 'event.list'});
                    });
            }
        },
        mounted() {
            this.getEvent();
        }
    }
</script>