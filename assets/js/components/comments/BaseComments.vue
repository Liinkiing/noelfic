<template>
    <transition name="fade-up" appear>
        <div class="comments-container">
            <ApolloMutation v-if="canComment" :mutation="require('../../graphql/mutations/AddCommentMutation.graphql')"
                            @done="onDone"
                            :variables="{ input: { relatedId, body: newComment } }"
                            :refetch-queries="() => queriesToRefetch ? queriesToRefetch : []">
                <template slot-scope="{ mutate, loading, gqlError }">
                    <form class="comment-form" @submit.prevent="comment(mutate)">
                        <Loader v-if="loading" absolute size="large" with-background/>
                        <base-alert v-if="gqlError" type="warning" dismissible>{{ $t(gqlError.message) }}</base-alert>
                        <textarea
                                class="form-control form-control-alternative"
                                :disabled="loading" name="body"
                                :placeholder="$t('form.comment.message')" v-model="newComment"></textarea>
                        <base-button :disabled="loading || !canPostComment" native-type="submit" icon="fa fa-comment"
                                     type="success" icon-only></base-button>
                    </form>
                </template>
            </ApolloMutation>
            <base-alert v-else-if="user && !user.confirmed" icon="fa fa-user" type="warning">
                <template slot="text">
                    {{ $t('errors.comment.post_forbidden') }}
                </template>
            </base-alert>
            <div v-else class="login-informtations">
                <base-alert icon="fa fa-user" type="primary">
                    <template slot="text">
                        {{ $t('form.comment.needs_auth') }}
                    </template>
                </base-alert>
            </div>
            <transition name="fade-up" appear>
                <component class="root-comments"
                           v-if="type === 'fiction'"
                           :key="type"
                           :level="0"
                           :fiction-id="fictionId"
                           :queries-to-refetch="queriesToRefetch"
                           is="FictionComments"></component>
                <component class="root-comments"
                           v-else-if="type === 'fictionChapter'"
                           :key="type"
                           :level="0"
                           :chapter-id="chapterId"
                           :queries-to-refetch="queriesToRefetch"
                           is="FictionChapterComments"></component>
            </transition>
        </div>
    </transition>
</template>

<script>
    import FictionChapterComments from "../fiction/chapter/FictionChapterComments";
    import FictionComments from "../fiction/FictionComments";
    import {mapState} from 'vuex'
    import Loader from "../ui/Loader";
    import {COMMENT_BODY_MIN_LENGTH} from "../../constants";

    export default {
        name: 'BaseComments',
        components: {Loader, FictionComments, FictionChapterComments},
        props: {
            fictionId: {type: String, required: false},
            chapterId: {type: String, required: false},
            type: {type: String, required: true, validator: value => ['fiction', 'fictionChapter'].includes(value)},
            queriesToRefetch: {type: Array, required: false, default: null}
        },
        data() {
            return {
                newComment: ''
            }
        },
        methods: {
            onDone() {
                this.newComment = '';
            },
            comment(mutate) {
                if (this.newComment === '') return;
                mutate()
            }
        },
        computed: {
            ...mapState('app', ['user']),
            canComment() {
                return this.user && this.user.confirmed
            },
            canPostComment() {
                return this.newComment.length > COMMENT_BODY_MIN_LENGTH
            },
            relatedId() {
                switch (this.type) {
                    case 'fiction':
                        return this.fictionId
                    case 'fictionChapter':
                        return this.chapterId
                }
                return null
            }
        }
    }
</script>

<style lang="scss" scoped>
    .comment-form {
        position: relative;
        & textarea {
            width: 100%;
            min-height: 58px;
            overflow-y: hidden;
        }
        & button {
            position: absolute;
            right: 10px;
            bottom: 10px;
        }
        margin-bottom: 1rem;
    }

    .root-comments {
        position: relative;
        padding: 0;
        min-height: 200px;
    }
</style>