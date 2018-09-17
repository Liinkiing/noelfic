<template>
    <ApolloMutation :mutation="require('../../graphql/mutations/AddAnswerCommentMutation.graphql')"
                    :variables="{ input: { commentId: to, body} }"
                    :refetch-queries="() => queriesToRefetch ? queriesToRefetch : []">
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

</style>