<template>
    <div class="">
        <main>
            <Header />
            <RouterView />
        </main>
    </div>
</template>

<script>
import Header from './components/Header.vue'
import { INTERNAL_SERVER_ERROR } from './util'

export default {
    components: {
        Header
    },
}
</script>