<template>
    <transition name="modal" appear>
        <div class="modal modal-overlay" @click.self="$emit('close')">
            <div class="modal-window">
                <div class="modal-content">
                    <slot/>
                    <div class="modal-close" @click.self="$emit('close')">とじる</div>
                </div>
            </div>
        </div>
    </transition>
</template>