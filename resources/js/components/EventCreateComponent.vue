<template>
    <div class="event-container">
        <div class="event-form-wrapper">  
            <form v-on:submit.prevent="submit">
                <label for="name">名前</label>
                <input type="text" id="name" v-model="event.name">
                <label for="description">詳細</label>
                <input type="text" id="description" v-model="event.description">
                <label for="date">日程</label>
                <input type="date" id="date" v-model="event.date">
                <label for="time">開始時間</label>
                <input type="time" id="open_time" v-model="event.open_time">
                <label for="time">終了時間</label>
                <input type="time" id="close_time" v-model="event.close_time">
                <button class="btn-submit" type="submit">作成</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                event: {}
            }
        },
        methods: {
            submit() {
                axios.post('/api/events', this.event)
                    .then((res) => {
                        this.$router.push({name: 'event.list'});
                    });
            }
        }
    }
</script>