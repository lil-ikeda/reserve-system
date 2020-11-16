<template>
    <div class="">
        <main>
            <Header />
            <div class="event-container">
                <Message />
                <RouterView />
            </div>
            <Footer />
        </main>
    </div>
</template>

<script>
import Header from './components/Header.vue'
import Message from './components/Message.vue'
import Footer from './components/Footer.vue'
import { INTERNAL_SERVER_ERROR } from './util'

export default {
    components: {
        Header,
        Message,
        Footer,
    },
    computed: {
        errorCode() {
            return this.$store.state.error.code
        }
    },
    watch: {
        errorCode: {
            handler(val) {
                if(val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500')
                }
            },
            immediate: true
        },
        $route() {
            this.$store.commit('error/setCode', null)
        }
    }
}
</script>
