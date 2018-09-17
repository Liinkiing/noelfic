<template>
    <ul class="comments" v-if="comments">
        <template v-for="comment in comments">
            <keep-alive>
                <!--<transition-group name="fade-up" mode="out-in" appear>-->
                    <comment :level="level + 1" :queries-to-refetch="queriesToRefetch" :key="comment.id" :comment="comment"></comment>
                <!--</transition-group>-->
            </keep-alive>
            <transition name="fade-up" appear>
                <comments v-if="comment.children.length > 0" :comments="comment.children" :queries-to-refetch="queriesToRefetch" :level="level + 1"></comments>
            </transition>
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
            comments: {type: Array, required: true, default: []},
            queriesToRefetch: {type: Array, required: false, default: null},
            level: {type: Number, required: true, default: 0}
        }
    }
</script>

<style lang="scss" scoped>

</style>