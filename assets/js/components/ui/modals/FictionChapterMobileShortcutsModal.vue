<template>
    <transition name="fade-up">
        <modal body-classes="d-flex align-items-center" modal-classes="modal-info" v-if="show" :show="show" gradient="primary" @close="$emit('close')">
            <template slot="header">
                {{ $t('modal.fiction.chapter.mobile_shortcut.title') }}
            </template>
            <div class="text-center">
                <i class="fa fa-mobile-phone fa-3x"></i>
                <h4 class="heading mt-4">{{ $t('modal.fiction.chapter.mobile_shortcut.heading') }}</h4>
                <p v-html="$t('modal.fiction.chapter.mobile_shortcut.paragraph')" class="mt-4">
                    {{ $t('modal.fiction.chapter.mobile_shortcut.paragraph') }}
                </p>
            </div>
            <template slot="footer">
                <base-button type="secondary" @click="$emit('close')">
                    {{ $t('modal.fiction.chapter.mobile_shortcut.understood') }}
                </base-button>
            </template>
        </modal>
    </transition>
</template>

<script>
    import Modal from "vue-argon-design-system/src/components/Modal";

    export default {
        name: 'FictionChapterMobileShortcutsModal',
        components: {Modal},
        props: {
            show: {type: Boolean, required: true},
        }
    }
</script>

<style lang="scss" scoped>

</style>