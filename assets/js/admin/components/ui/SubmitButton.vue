<template>
    <div class="submit-button-container">
        <md-button :disabled="loading" v-bind="$attrs" v-on="$listeners" :class="`md-${type}`" :type="nativeType">
            <slot></slot>
        </md-button>
        <transition name="fade-up" appear mode="out-in">
            <Loader v-if="loading" inline size="small" with-background key="loader"/>

            <span class="error text-danger" v-else-if="error" key="error">
                {{ $t('message' in error ?
                error.message.split("\n").map(e => e.replace('GraphQL error: ', '')).join(' | ') :
                error) }}
            </span>
        </transition>
    </div>
</template>

<script>
    import Loader from "../../../components/ui/Loader";

    export default {
        inheritAttrs: false,
        name: 'SubmitButton',
        components: {Loader},
        props: {
            loading: {type: Boolean, default: false},
            error: {type: [Object, String, Error], default: null},
            nativeType: {type: String, default: 'submit'},
            type: {type: String, default: 'primary', validator: input => ['primary', 'accent'].includes(input)},
        }
    }
</script>

<style lang="scss" scoped>
    .submit-button-container {
        display: flex;
        align-items: center;
    }
    .loader,span.error {
        margin-left: 20px;
    }
</style>