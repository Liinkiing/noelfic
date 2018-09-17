<template>
    <ul class="comments" v-if="rootComments && rootComments.edges">
        <template v-for="comment in rootComments.edges.map(edge => edge.node)">
            <keep-alive>
                <transition name="fade-up" appear>
                    <comment :queries-to-refetch="queriesToRefetch" :key="comment.id" :comment="comment"></comment>
                </transition>
            </keep-alive>
            <comments :queries-to-refetch="queriesToRefetch"
                      v-if="comment.children.length > 0"
                      :comments="comment.children"></comments>
        </template>
    </ul>

</template>

<script>
    import Comment from "../comments/Comment";

    export default {
        name: 'FictionComments',
        components: {Comment},
        props: {
            fiction: {type: Object, required: true},
            queriesToRefetch: {type: Array, required: false, default: null}
        },
        apollo: {
            rootComments: {
                query: require('../../graphql/queries/FictionCommentsQuery.graphql'),
                variables() {
                    return {fictionId: this.fiction.id}
                },
                update: data => data.node.rootComments
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>