<template>
    <transition name="fade-up" appear>
        <div class="comments-container">
            <ApolloMutation v-if="user" :mutation="require('../../graphql/mutations/AddCommentMutation.graphql')"
                            :variables="{ input: { relatedId, body: newComment } }"
                            :refetch-queries="() => queriesToRefetch ? queriesToRefetch : []">
                <template slot-scope="{ mutate, loading, error }">
                    <form class="comment-form" @submit.prevent="comment(mutate)">
                    <textarea
                            class="form-control form-control-alternative"
                            :disabled="loading" name="body"
                            :placeholder="$t('form.comment.message')" v-model="newComment"></textarea>
                        <base-button :disabled="loading" native-type="submit" icon="fa fa-comment"
                                     type="success" @click="comment(mutate)" icon-only></base-button>
                    </form>
                </template>
            </ApolloMutation>
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

    export default {
        name: 'BaseComments',
        components: {FictionComments, FictionChapterComments},
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
            comment(mutate) {
                if (this.newComment === '') return;
                mutate()
                this.newComment = '';
            }
        },
        computed: {
            ...mapState('app', ['user']),
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
        }
        & button {
            position: absolute;
            z-index: 1;
            right: 10px;
            bottom: 10px;
        }
        margin-bottom: 1rem;
    }
    .root-comments {
        padding: 0;
    }
</style>