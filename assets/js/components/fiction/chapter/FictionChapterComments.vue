<template>
    <ul class="comments" v-if="rootComments && rootComments.edges">
        <template v-for="comment in rootComments.edges.map(edge => edge.node)">
            <keep-alive>
                <transition name="fade-up" appear>
                    <comment :level="level" :queries-to-refetch="queriesToRefetch" :key="comment.id" :comment="comment"></comment>
                </transition>
            </keep-alive>
            <comments :queries-to-refetch="queriesToRefetch"
                      v-if="comment.children.length > 0"
                      :level="level + 1"
                      :comments="comment.children"></comments>
        </template>
    </ul>

</template>

<script>
    import Comment from "../../comments/Comment";

    export default {
        name: 'FictionChapterComments',
        components: {Comment},
        props: {
            chapter: {type: Object, required: true},
            queriesToRefetch: {type: Array, required: false, default: null},
            level: {type: Number, required: true, default: 0},
        },
        apollo: {
            rootComments: {
                query: require('../../../graphql/queries/FictionChapterCommentsQuery.graphql'),
                variables() {
                    return {chapterId: this.chapter.id}
                },
                update: data => data.node.rootComments
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>