<template>
    <li class="comment" v-on-click-away="deactivate" @click.prevent="activate"
        :class="{active, authenticated: user, 'max-level': tooDeep}">
        <img class="profile-picture img-fluid rounded shadow" src="../../../images/default_avatar.png">
        <div class="comment-content">
            <div class="comment-data">
                {{ comment.author.username }} - {{ comment.body }}<br/>
                <small>{{ comment.createdAt|moment }}</small>
            </div>
            <ApolloMutation v-if="canDeleteComment"
                            :refetch-queries="() => queriesToRefetch"
                            :mutation="require('../../graphql/mutations/DeleteCommentMutation.graphql')"
                            :variables="{ input: { commentId: comment.id } }">
                <template slot-scope="{ mutate, loading, gqlError }">
                    <modal v-if="user" gradient="danger" :show="deleteForm" modal-classes="modal-danger" @close="closeDeleteForm" type="notice">
                        <div class="text-center">
                            <i class="fa fa-trash-o fa-3x"></i>
                            <h4 class="heading mt-4 mb-4">{{ $t('modal.comment.delete.header') }}</h4>
                            <p>{{ $t('modal.comment.delete.body') }}</p>
                        </div>
                        <template slot="footer">
                            <button type="button" class="btn btn-white" @click="() => { mutate(); disabled = true; closeDeleteForm(); }">{{ $t('global.delete') }}</button>
                            <button type="button" class="btn btn-link text-white ml-auto" @click="closeDeleteForm">{{ $t('global.close') }}</button>
                        </template>
                    </modal>
                    <base-button class="btn-delete-comment" type="danger"
                                 icon-only icon="fa fa-trash" @click="showDeleteForm" :disabled="loading"></base-button>
                </template>
            </ApolloMutation>
            <keep-alive v-if="user">
                <comment-form :disabled="disabled" @commented="deactivate" class="comment-form" :queries-to-refetch="queriesToRefetch"
                              v-if="active && !tooDeep"
                              :to="comment.id"></comment-form>
            </keep-alive>
            <transition name="fade-up">
                <badge v-if="user && active && tooDeep" class="answer-badge" type="warning">{{
                    $t('form.comment.too_deep') }}
                </badge>
            </transition>
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
    import CommentForm from "./CommentForm";
    import Modal from "vue-argon-design-system/src/components/Modal";
    import Loader from "../ui/Loader";

    export default {
        name: 'Comment',
        components: {Loader, Modal, CommentForm},
        directives: {
            onClickAway,
        },
        computed: {
            ...mapState('app', ['user']),
            tooDeep() {
                return this.level >= 6
            },
            canDeleteComment() {
                return this.user && (this.user.admin || this.user.username === this.comment.author.username)
            }
        },
        data() {
            return {
                active: false,
                disabled: false,
                deleteForm: false,
            }
        },
        props: {
            comment: {type: Object, required: true},
            level: {type: Number, required: true, default: 0},
            queriesToRefetch: {type: Array, required: false, default: null},
        },
        methods: {
            closeDeleteForm() {
                this.deleteForm = false
            },
            showDeleteForm() {
                this.deleteForm = true
            },
            activate() {
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
        & .btn-delete-comment {
            position: absolute;
            bottom: 10px;
            right: 10px;
            box-shadow: $imageBoxShadow;
        }
        &:hover {
            cursor: pointer;
            background: darken(white, 4%);
            box-shadow: $commentBoxShadow;
        }
        &.active {
            background: $primaryGradient;
            box-shadow: $commentBoxShadowActive;
            color: whitesmoke;
            &.authenticated:not(.max-level) {
                max-height: 180px;
                height: 180px;
            }
            & .btn-delete-comment {
                top: 10px;
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
        bottom: 10px;
        right: 10px;
    }
</style>