<template>
    <transition name="fade-up" appear>
        <BaseForm class="fiction-form edit" @on-submit="submitAction">
            <GlobalLoader v-if="loading"/>
            <TextField label="admin.fiction.form.title"
                       name="title"
                       v-model="input.title"
                       validation-rules="required|min:5,max:100"/>
            <h2 v-text="$t('admin.fiction.form.chapters')"></h2>
            <ul class="list-items-container" v-if="fiction">
                <draggable v-model="chaptersDraggable" :options="{animation: 30}">
                    <li class="list-item" v-for="chapter in chaptersDraggable" :key="chapter.id">
                        {{ chapter.title }}
                    </li>
                </draggable>
            </ul>
            <md-button class="md-primary" @click="showFictionChapterFormModal = true">
                {{ $t('admin.fiction.form.add_chapter') }}
            </md-button>
            <FictionChapterFormModal :show="showFictionChapterFormModal"
                                     :fiction="fiction"
                                     @close="showFictionChapterFormModal = false"/>
            <MultiSelect :query="require('../../../graphql/queries/FictionCategoriesQuery.graphql')"
                         :inital-values="fiction !== null ? fiction.categories.map(category => category.id) : []"
                         @md-selected="onCategoryChange"
                         label="admin.fiction.form.categories"
                         name="categories">

            </MultiSelect>
            <SubmitButton :error="error" type="primary">
                {{ $t('global.submit') }}
            </SubmitButton>
        </BaseForm>
    </transition>
</template>

<script>
    import draggable from 'vuedraggable'
    import ListItems from "../ListItems";
    import MultiSelect from "./MultiSelect";
    import SubmitButton from "../SubmitButton";
    import TextField from "./TextField";
    import Loader from "../../../../components/ui/Loader";
    import BaseForm from "./BaseForm";
    import GlobalLoader from "../../../../components/ui/GlobalLoader";
    import FictionChapterFormModal from "../modals/FictionChapterFormModal";

    export default {
        extends: BaseForm,
        name: 'FictionForm',
        components: {
            FictionChapterFormModal,
            GlobalLoader, BaseForm, Loader, TextField, SubmitButton, MultiSelect, ListItems, draggable
        },
        props: {
            fiction: {type: Object, default: null},
            chapters: {type: Array, default: () => []},
        },
        data() {
            return {
                showFictionChapterFormModal: false,
                loading: false,
                error: null,
                chaptersDraggable: [],
                input: {
                    fictionId: '',
                    title: '',
                    categoriesId: [],
                    chaptersPosition: []
                }
            }
        },
        mounted() {
            if (this.fiction) {
                this.input.fictionId = this.fiction.id
                this.chaptersDraggable = this.chapters
                this.input.title = this.fiction.title
            }
        },
        computed: {
            submitAction() {
                return this.fiction !== null ?
                    this.editFiction :
                    this.addFiction
            }
        },
        methods: {
            async addFiction() {
                this.loading = true
                const {title, fictionId, categoriesId} = this.input
                try {
                    const result = await this.$apollo.mutate({
                        mutation: require('../../../graphql/mutations/AddFictionMutation.graphql'),
                        variables: {
                            input: {title, fictionId, categoriesId}
                        }
                    })
                    const {data: {addFiction: {fiction: {id}}}} = result
                    window.location.href = this.$routing.generate('admin.fiction_edit', {id})
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
                } catch (e) {
                    this.error = e
                }
                this.loading = false
            },
            onCategoryChange(categoriesId) {
                this.input.categoriesId = categoriesId
            }
        },
        watch: {
            chapters() {
                this.chaptersDraggable = this.chapters
            },
            chaptersDraggable() {
                this.input.chaptersPosition = this.chaptersDraggable.map((chapter, i) => ({
                    fictionChapterId: chapter.id,
                    position: (i + 1)
                }))
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>