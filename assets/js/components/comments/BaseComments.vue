<template>
    <div class="comments-container">
        <ApolloMutation v-if="user" :mutation="require('../../graphql/mutations/AddCommentMutation.graphql')"
                        :variables="{ input: { relatedId, body: newComment } }"
                        :refetch-queries="() => queriesToRefetch ? queriesToRefetch : []">
            <template slot-scope="{ mutate, loading, error }">
                <form class="comment-form" @submit.prevent="comment(mutate)">
                    <label>{{ $t('form.comment.message') }}
                        <textarea :disabled="loading" name="body" v-model="newComment"></textarea>
                    </label>
                    <button :disabled="loading" type="submit" @click="comment(mutate)">{{ $t('global.submit') }}</button>
                </form>
            </template>
        </ApolloMutation>
        <div v-else class="login-informtations">
            {{ $t('form.comment.needs_auth') }}
        </div>
        <transition name="fade-up" appear>
            <component v-if="type === 'fiction'"
                       :key="type"
                       :fiction="fiction"
                       :queries-to-refetch="queriesToRefetch"
                       is="FictionComments"></component>
            <component v-else-if="type === 'fictionChapter'"
                       :key="type"
                       :chapter="chapter"
                       :queries-to-refetch="queriesToRefetch"
                       is="FictionChapterComments"></component>
        </transition>
    </div>
</template>

<script>
    import FictionChapterComments from "../fiction/chapter/FictionChapterComments";
    import FictionComments from "../fiction/FictionComments";
    import { mapState } from 'vuex'
    export default {
        name: 'BaseComments',
        components: {FictionComments, FictionChapterComments},
        props: {
            fiction: {type: Object, required: false},
            chapter: {type: Object, required: false},
            type: {type: String, required: true, validator: value => ['fiction', 'fictionChapter'].includes(value)},
            queriesToRefetch: {type: Array, required: false, default: null}
        },
        data() {
            return {
                newComment: ''
            }
        },
        methods: {
            async comment(mutate) {
                if (this.newComment === '') return;
                await mutate()
                this.newComment = '';
            }
        },
        computed: {
            ...mapState('app', ['user']),
            relatedId() {
                switch (this.type) {
                    case 'fiction':
                        return this.fiction.id
                    case 'fictionChapter':
                        return this.chapter.id
                }
                return null
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>