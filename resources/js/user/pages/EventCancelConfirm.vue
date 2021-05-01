<template>
    <div class="main-container">
        <div class="main-container__inner">
            <div class="entry-headline">キャンセルメール送信完了</div>
            <div class="event-info__entry">
                <div class="confirm-mail-icon">
                    <img src="/img/paper-plane.png">
                </div>
                <div>
                    運営事務局宛にキャンセルリクエストのメールを送信しております。
                    運営事務局よりキャンセル確定メールが届くのをお待ちください。
                </div>
            </div>
            <div class="d-flex justify-content-center font-weight-bold">
                <a :href="routeToTop">トップページへ戻る</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            routeToTop: {
                type: String
            }
        }
    }
</script>
