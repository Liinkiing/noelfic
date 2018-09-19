<template>
    <portal to="modals">
        <transition name="fade-up">
            <modal modal-classes="modal-info" v-if="show" :show="show" gradient="primary" @close="$emit('close')">
                <template slot="header">
                    {{ $t('modal.fiction.chapter.desktop_shortcut.title') }}
                </template>
                <div class="text-center">
                    <icon-base class="keyboard-icon" height="260" width="260" view-box="-7 42 160 18">
                        <icon-keyboard/>
                    </icon-base>
                </div>
                <p class="text-center">
                    <key-code :disabled="!canGoPrev" @click="$emit('prev')" class="mr-4" code="37"/>
                    {{ $t('or') }}
                    <key-code :disabled="!canGoNext" @click="$emit('next')" class="ml-4" code="39"/>
                    <span class="ml-4">
                    {{ $t('modal.fiction.chapter.desktop_shortcut.change_chapter') }}
                </span>
                </p>
                <template slot="footer">
                    <base-button type="secondary" @click="$emit('close')">
                        {{ $t('modal.fiction.chapter.desktop_shortcut.understood') }}
                    </base-button>
                </template>
            </modal>
        </transition>
    </portal>
</template>

<script>
    import Modal from "vue-argon-design-system/src/components/Modal";
    import KeyCode from "../KeyCode";
    import IconKeyboard from "../icon/icons/IconKeyboard";
    export default {
        name: 'FictionChapterDesktopShortcutsModal',
        components: {IconKeyboard, KeyCode, Modal},
        props: {
            canGoPrev: {type: Boolean, required: true},
            show: {type: Boolean, required: true},
            canGoNext: {type: Boolean, required: true},
        }
    }
</script>

<style lang="scss" scoped>

</style>