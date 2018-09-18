<template>
    <ApolloMutation :mutation="require('../../graphql/mutations/AddAnswerCommentMutation.graphql')"
                    :variables="{ input: { commentId: to, body} }"
                    @done="done"
                    :refetch-queries="() => queriesToRefetch ? queriesToRefetch : []">
        <template slot-scope="{ mutate, loading, gqlError }">
            <form class="comment-form" @submit.prevent="comment(mutate)">
                <Loader v-if="disabled || loading" absolute size="large" with-background/>
                <div class="form-container">
                    <textarea
                            class="form-control form-control-alternative"
                            :disabled="disabled || loading" name="body"
                            :placeholder="$t('form.comment.message')" v-model="body"></textarea>
                    <base-button :disabled="!canComment || disabled || loading" native-type="submit" icon="fa fa-comment"
                                 type="success" @click="comment(mutate)" icon-only></base-button>
                </div>
            </form>
        </template>
    </ApolloMutation>
</template>

<script>
    import Loader from "../ui/Loader";
    import {COMMENT_BODY_MIN_LENGTH} from "../../constants";
    export default {
        name: 'CommentForm',
        components: {Loader},
        props: {
            to: {type: String, required: true},
            disabled: {type: Boolean, required: false, default: false},
            queriesToRefetch: {type: Array, required: false, default: null},
        },
        data() {
            return {
                body: ''
            }
        },
        computed: {
            canComment() {
                return this.body.length > COMMENT_BODY_MIN_LENGTH
            }
        },
        methods: {
            comment(mutate) {
                if (!this.canComment) return;
                mutate()
            },
            done() {
                this.body = '';
                this.$emit('commented')
            }
        }
    }
</script>

<style lang="scss" scoped>
    .comment-form {
        & .form-container {
            position: relative;
        }
        & textarea {
            width: 100%;
            resize: none;
            min-height: 58px;
            overflow-y: hidden;
        }
        & button {
            position: absolute;
            right: 10px;
            bottom: 10px;
        }
    }
</style>