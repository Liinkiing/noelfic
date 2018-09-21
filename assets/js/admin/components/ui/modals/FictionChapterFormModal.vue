<template>
    <portal to="modals">
        <transition name="fade-up">
            <modal modal-classes="modal-info" v-if="show" :show="show" gradient="primary" @close="$emit('close')">
                <template slot="header">
                    {{ $t('modal.fiction.chapter.desktop_shortcut.title') }}
                </template>
                <FictionChapterForm :fiction="fiction" @mutation-done="onMutationDone">

                </FictionChapterForm>
            </modal>
        </transition>
    </portal>
</template>

<script>
    import Modal from "vue-argon-design-system/src/components/Modal";
    import FictionChapterForm from "../form/FictionChapterForm";

    export default {
        name: 'FictionChapterFormModal',
        components: {FictionChapterForm, Modal},
        props: {
            show: {type: Boolean, required: true},
            fiction: {type: Object, required: true},
        },
        methods: {
            onMutationDone(result) {
                console.log(result)
                this.$emit('close')
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>