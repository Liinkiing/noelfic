<template>
    <li class="comment" v-on-click-away="deactivate" @click.prevent="activate" :class="{active, authenticated: user}">
        <img class="profile-picture img-fluid rounded shadow" src="../../../images/default_avatar.png">
        <div class="comment-content">
            <div class="comment-data">
                {{ comment.author.username }} - {{ comment.body }}<br/>
                <small>{{ comment.createdAt|moment }}</small>
            </div>
            <keep-alive v-if="user && level < 6">
                <comment-form class="comment-form" :queries-to-refetch="queriesToRefetch" v-if="active"
                              :to="comment.id"></comment-form>
            </keep-alive>
            <transition name="fade-up">
                <badge v-if="active && !user" class="answer-badge" type="warning">{{
                    $t('form.comment.answer_needs_auth') }}
                </badge>
            </transition>
        </div>
    </li>
</template>

<script>
    import {mapState} from 'vuex'
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
        data() {
            return {
                active: false
            }
        },
        props: {
            comment: {type: Object, required: true},
            level: {type: Number, required: true, default: 0},
            queriesToRefetch: {type: Array, required: false, default: null},
        },
        methods: {
            activate() {
                if (this.level >= 6) return;
                this.active = true
            },
            deactivate() {
                this.active = false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .comment {
        transition: max-height $defaultTransitionDuration, background $defaultTransitionDuration;
        position: relative;
        display: flex;
        align-items: center;
        background: white;
        padding: 20px;
        border-radius: $borderRadius;
        list-style: none;
        max-height: 88px;
        margin-bottom: 1rem;
        &:hover {
            cursor: pointer;
            background: darken(white, 4%);
            box-shadow: $commentBoxShadow;
            z-index: 1;
        }
        &.active {
            background: lighten($primary, 5%);
            box-shadow: $imageBoxShadowRaised;
            color: whitesmoke;
            z-index: 2;
            &.authenticated {
                max-height: 180px;
                height: 180px;
            }
            &:hover {
                background: lighten($primary, 10%);
            }
            & .comment-form {
                margin-top: 1rem;
            }
        }
    }

    .profile-picture {
        width: 30px;
        height: 30px;
    }

    .comment-content {
        margin-left: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        width: 100%;
    }

    .answer-badge {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }
</style>