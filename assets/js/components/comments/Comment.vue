<template>
        <li class="comment" v-on-click-away="deactivate" @click.prevent="activate" :class="{active}">{{ comment.author.username }} - {{ comment.body }}<br/>
            <small>{{ comment.createdAt|moment }}</small>
            <keep-alive v-if="user">
                <comment-form :queries-to-refetch="queriesToRefetch" v-if="active" :to="comment.id"></comment-form>
            </keep-alive>
            <div v-else-if="active && !user">
                {{ $t('form.comment.needs_auth') }}
            </div>
        </li>
</template>

<script>
    import { mapState} from 'vuex'
    import {directive as onClickAway} from 'vue-clickaway';
    import CommentAnswerForm from "./CommentAnswerForm";

    export default {
        name: 'Comment',
        components: {CommentAnswerForm},
        directives: {
            onClickAway,
        },
        computed: {
            ...mapState('app', ['user'])
        },
        data () {
            return {
                active: false
            }
        },
        props: {
            comment: {type: Object, required: true},
            queriesToRefetch: {type: Array, required: false, default: null},
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