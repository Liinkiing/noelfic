<template>
    <li class="comment" v-on-click-away="deactivate" @click.prevent="activate" :class="{active}">{{ comment.author.username }} - {{ comment.body }}<br/>
        <small>{{ comment.createdAt|moment }}</small>
        <keep-alive>
            <comment-form v-if="active" :to="comment.id"></comment-form>
        </keep-alive>
    </li>
</template>

<script>
    import {directive as onClickAway} from 'vue-clickaway';
    import CommentForm from "./CommentForm";

    export default {
        name: 'Comment',
        components: {CommentForm},
        directives: {
            onClickAway,
        },
        data () {
            return {
                active: false
            }
        },
        props: {
            comment: {type: Object, required: true},
        },
        methods: {
            activate () {
                this.active = true
            },
            deactivate () {
                this.active = false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .comment {
        &.active {
            background: transparentize(black, 0.9);
        }
    }
</style>