<template>
    <form class="comment-form" @submit.prevent="comment">
        <label>{{ $t('form.comment.message') }}
            <textarea name="body" v-model="body"></textarea>
        </label>
        <button type="submit" @click="comment">{{ $t('global.submit') }}</button>
    </form>
</template>

<script>
    export default {
        name: 'CommentForm',
        props: {
            to: {type: String, required: true}
        },
        data () {
            return {
                body: ''
            }
        },
        methods: {
            comment() {
                if (this.body === '') return;

                this.body = '';
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>