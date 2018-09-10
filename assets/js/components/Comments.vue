<template>
    <ul class="comments">
        <template v-for="comment in comments">
            <keep-alive>
                <comment :comment="comment"></comment>
            </keep-alive>
            <comments ref="comments" v-if="comment.children.length > 0" :data-comments="JSON.stringify(comment.children)"></comments>
        </template>
    </ul>
    
</template>

<script>
    import Comment from "./Comment";
    export default {
        name: 'Comments',
        components: {Comment},
        data () {
            return {
                comments: [],
            }
        },
        mounted () {
            this.comments = JSON.parse(this.$el.dataset.comments);
            delete this.$el.dataset.comments;
        }
    }
</script>

<style lang="scss" scoped>

</style>