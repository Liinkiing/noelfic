<template>
    <transition name="fade-up" appear>
        <BaseForm class="fiction-chapter-form" @on-submit="submitAction">
            <TextField label="admin.fiction.form.title"
                       name="title"
                       class="md-theme-dark"
                       v-model="input.title"
                       validation-rules="required|min:5,max:100"/>
            <TextField label="admin.fiction.form.title"
                       name="body"
                       class="md-theme-dark"
                       v-model="input.body"
                       validation-rules="required|min:5,max:100"/>
            <SubmitButton :error="error" type="primary">
                {{ $t('global.submit') }}
            </SubmitButton>
        </BaseForm>
    </transition>
</template>

<script>
    import BaseForm from './BaseForm'
    import SubmitButton from "../SubmitButton";
    import TextField from "./TextField";

    export default {
        components: {TextField, SubmitButton, BaseForm},
        extends: BaseForm,
        name: 'FictionChapterForm',
        props: {
            fiction: {type: Object, required: true},
        },
        data() {
            return {
                loading: false,
                error: null,
                input: {
                    fictionId: '',
                    title: '',
                    body: '',
                }
            }
        },
        mounted() {
            if (this.fiction) {
                this.input.fictionId = this.fiction.id
            }
        },
        computed: {
            submitAction() {
                return this.addChapter
            }
        },
        methods: {
            resetInput() {
                this.input = {
                    fictionId: '',
                    title: '',
                    body: '',
                }
            },
            async addChapter() {
                this.loading = true
                const {title, fictionId, body} = this.input
                try {
                    const result = await this.$apollo.mutate({
                        mutation: require('../../../graphql/mutations/AddFictionChapterMutation.graphql'),
                        variables: {
                            input: {title, fictionId, body}
                        }
                    })
                    this.resetInput()
                    this.$emit('mutation-done', result)
                } catch (e) {
                    this.error = e
                }
                this.loading = false
            },
            async editFiction() {
                this.loading = true
                const {title, fictionId, categoriesId, chaptersPosition} = this.input
                try {
                    await this.$apollo.mutate({
                        mutation: require('../../../graphql/mutations/EditFictionMutation.graphql'),
                        variables: {
                            input: {title, fictionId, categoriesId, chaptersPosition}
                        }
                    })
                    this.closeModal()
                    this.resetInput()
                } catch (e) {
                    this.error = e
                }
                this.loading = false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .fiction-chapter-form {
        color: whitesmoke;
    }
</style>