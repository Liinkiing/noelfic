<template>
    <ul class="comments" v-if="rootComments && rootComments.edges">
        <template v-for="comment in rootComments.edges.map(edge => edge.node)">
            <keep-alive>
                <comment :comment="comment"></comment>
            </keep-alive>
            <comments v-if="comment.children.length > 0" :comments="comment.children"></comments>
        </template>
    </ul>

</template>

<script>
    import Comment from "../../Comment";

    export default {
        name: 'FictionChapterComments',
        components: {Comment},
        props: {
            chapter: {type: Object, required: true}
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