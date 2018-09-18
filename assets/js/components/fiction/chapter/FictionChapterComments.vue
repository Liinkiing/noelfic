<template>
    <ul class="comments" v-if="chapter && chapter.rootComments && chapter.rootComments.edges">
        <h2>{{ $tc('global.comments', chapter.comments.totalCount ) }}</h2>
        <template v-for="comment in chapter.rootComments.edges.map(edge => edge.node)">
            <!--<keep-alive>-->
                <!--<transition name="fade-up" appear>-->
            <comment :level="level" :queries-to-refetch="queriesToRefetch" :key="comment.id" :comment="comment"></comment>
                <!--</transition>-->
            <!--</keep-alive>-->
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
            chapterId: {type: String, required: true},
            queriesToRefetch: {type: Array, required: false, default: null},
            level: {type: Number, required: true, default: 0},
        },
        apollo: {
            chapter: {
                query: require('../../../graphql/queries/FictionChapterCommentsQuery.graphql'),
                variables() {
                    return {chapterId: this.chapterId}
                },
                update: data => data.node
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>