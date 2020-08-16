<template>
    <div class="event-container">
        <div class="event-form-wrapper">  
            <div v-show="loading">
                <Loader />
            </div>
            <form v-show="! loading" @submit.prevent="submit">
                <div class="errors" v-if="errors">
                    <ul v-if="errors.event">
                        <li v-for="msg in errors.photo" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
                <!-- 写真 -->
                <input type="file" @change="onFileChange" name="fileinfo">
                <output v-if="preview">
                    <img :src="preview" alt="" class="event-form-wrapper__img-preview">
                </output>
                
                <label for="name">名前</label>
                <input type="text" id="name" v-model="event.name">
                <label for="description">詳細</label>
                <input type="text" id="description" v-model="event.description">
                <label for="date">日程</label>
                <input type="date" id="date" v-model="event.date">
                <label for="date">場所</label>
                <input type="text" id="place" v-model="event.place">
                <label for="date">料金</label>
                <input type="text" id="price" v-model="event.price">
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
import { UNPROCESSABLE_ENTITY, CREATED } from '../util'
import Loader from '../components/Loader.vue'

    export default {
        components: {
            Loader
        },
        data() {
            return {
                loading: false,
                preview: null,
                event: {},
                image: null,
                errors: null
            }
        },
        methods: {
            onFileChange(event) {
                // 何も選択されていなかったら処理中断
                if(event.target.files.length === 0) {
                    this.reset()
                    return false
                }
                // ファイルが画像ではなかったら処理中断
                if(! event.target.files[0].type.match('image.*')) {
                    this.reset()
                    return false
                }
                const reader = new FileReader()

                reader.onload = e => {
                    this.preview = e.target.result
                }
                
                reader.readAsDataURL(event.target.files[0])
                this.image = event.target.files[0]
            },
            reset() {
                this.preview = ''
                this.image = null
                this.$el.querySelector('input[type="file"]').value = null
            },
            async submit() {
                this.loading = true
                // formの入力内容をformDataに
                const formData = new FormData()
                formData.append('image', this.image)
                formData.append('name', this.event.name)
                formData.append('description', this.event.description)
                formData.append('date', this.event.date)
                formData.append('open_time', this.event.open_time)
                formData.append('close_time', this.event.close_time)
                formData.append('place', this.event.place)
                formData.append('price', this.event.price)

                const response = await axios.post('/api/events', formData)
                this.loafing = false
                // バリデーションエラーハンドリング
                if(response.status === UNPROCESSABLE_ENTITY) {
                    this.errors = response.data.errors
                    return false
                }
                this.reset()
                // イベント作成成功時
                if(response.status !== CREATED) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }
                this.$store.commit('message/setContent', {
                    content: 'イベントが作成されました！',
                    timeout: 6000
                })

                this.$router.push({name: 'event.list'});
            }
        }
    }
</script>