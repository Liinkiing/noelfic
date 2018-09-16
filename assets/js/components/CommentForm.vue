<template>
    <ApolloMutation :mutation="require('../graphql/mutations/AddFictionChapterCommentMutation.graphql')"
                    :variables="{ input: { commentId: to, body} }"
                    :refetch-queries="() => ['FictionChapterCommentsQuery']">
        <template slot-scope="{ mutate, loading, error }">
            <form class="comment-form" @submit.prevent="comment(mutate)">
                <label>{{ $t('form.comment.message') }}
                    <textarea :disabled="loading" name="body" v-model="body"></textarea>
                </label>
                <button :disabled="loading" type="submit" @click="comment(mutate)">{{ $t('global.submit') }}</button>
            </form>
        </template>
    </ApolloMutation>
</template>

<script>
    export default {
        name: 'CommentForm',
        props: {
            to: {type: String, required: true}
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

</style>