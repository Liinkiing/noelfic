<template>
    <ul class="comments" v-if="comments">
        <template v-for="comment in comments">
            <keep-alive>
                <transition-group name="fade-up" mode="out-in" appear>
                    <comment :key="comment.id" :comment="comment"></comment>
                </transition-group>
            </keep-alive>
            <comments v-if="comment.children.length > 0" :comments="comment.children"></comments>
        </template>
    </ul>
</template>

<script>
    import {SlideYUpTransition} from 'vue2-transitions'
    import Comment from "./Comment";

    export default {
        name: 'Comments',
        components: {Comment, SlideYUpTransition},
        props: {
            comments: {type: Array, required: true, default: []}
        }
    }
</script>

<style lang="scss" scoped>

</style>