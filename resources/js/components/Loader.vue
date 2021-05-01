<template>
    <div class="font-blue">
        <div class="loader-wrap">
            <div class="flower-spinner">
                <div class="dots-container">
                    <div class="bigger-dot">
                        <div class="smaller-dot"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">{{ title }}</div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String
        }
    },
}
</script>
