<template>
    <div class="footer">
        <div class="footer__title">
            <!-- <img :src="'/img/footer-logo.png'" style="width: 150px"> -->
            <span>ロゴ</span>
        </div>
        <ul class="d-flex justify-content-center mb-3">
            <li class="footer__icon">
               <font-awesome-icon :icon="['fab', 'instagram']" />
            </li>
            <li class="footer__icon">
               <font-awesome-icon :icon="['fab', 'facebook-square']" />
            </li>
            <li class="footer__icon">
               <font-awesome-icon :icon="['fab', 'twitter']" />
            </li>
            <li class="footer__icon">
               <font-awesome-icon :icon="['fab', 'youtube']" />
            </li>
        </ul>
        <div class="footer__copyright">Copyright @ skillhack.inc</div>
    </div>
</template>
