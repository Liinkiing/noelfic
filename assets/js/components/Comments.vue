<template>
    <ul class="comments">
        <template v-for="comment in comments">
            <keep-alive>
                <comment :comment="comment"></comment>
            </keep-alive>
            <comments v-if="comment.children.length > 0" :comments="comment.children"></comments>
        </template>
    </ul>
    
</template>

<script>
    import Comment from "./Comment";
    export default {
        name: 'Comments',
        components: {Comment},
        props: {
            comments: {type: Array, required: true, default: []}
        }
    }
</script>

<style lang="scss" scoped>

</style>