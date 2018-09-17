<template>
    <ApolloMutation :mutation="require('../../graphql/mutations/AddAnswerCommentMutation.graphql')"
                    :variables="{ input: { commentId: to, body} }"
                    :refetch-queries="() => queriesToRefetch ? queriesToRefetch : []">
        <template slot-scope="{ mutate, loading, error }">
            <form class="comment-form" @submit.prevent="comment(mutate)">
                <div class="form-container">
                    <textarea
                            class="form-control form-control-alternative"
                            :disabled="loading" name="body"
                            :placeholder="$t('form.comment.message')" v-model="body"></textarea>
                    <base-button :disabled="loading" native-type="submit" icon="fa fa-comment"
                                 type="success" @click="comment(mutate)" icon-only></base-button>
                </div>
            </form>
        </template>
    </ApolloMutation>
</template>

<script>
    export default {
        name: 'CommentAnswerForm',
        props: {
            to: {type: String, required: true},
            queriesToRefetch: {type: Array, required: false, default: null},
        },
        data() {
            return {
                body: ''
            }
        },
        methods: {
            async comment(mutate) {
                if (this.body === '') return;
                await mutate()
                this.body = '';
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
            min-height: 58px;
        }
        & button {
            position: absolute;
            z-index: 1;
            right: 10px;
            bottom: 10px;
        }
    }
</style>