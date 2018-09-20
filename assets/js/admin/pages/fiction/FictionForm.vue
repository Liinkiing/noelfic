<template>
    <transition name="fade-up" appear>
        <div v-if="!fiction" class="fiction-form new">

        </div>
        <div v-else class="fiction-form edit">
            <h1 v-text="$t('admin.fiction.edit.title', {title: fiction.title})"></h1>
            <ul class="list-items-container">
                <draggable v-model="chapters">
                    <transition-group name="list">
                        <li class="list-item" v-for="chapter in chapters" :key="chapter.id">
                            {{ chapter.title }}
                        </li>
                    </transition-group>
                </draggable>
            </ul>
        </div>
    </transition>
</template>

<script>
    import draggable from 'vuedraggable'
    import ListItems from "../../components/ui/ListItems";

    export default {
        name: 'FictionForm',
        components: {ListItems, draggable},
        props: {
            fiction: {type: Object, required: true},
        },
        data() {
            return {
                chapters: [],
                input: {
                    chaptersPosition: []
                }
            }
        },
        mounted() {
            this.chapters = this.fiction.chapters.edges.map(edge => edge.node)
        },
        watch: {
            chapters() {
                this.input.chaptersPosition = this.chapters.map((chapter, i) => ({
                    id: chapter.id,
                    position: (i + 1)
                }))
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>