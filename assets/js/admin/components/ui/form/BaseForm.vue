<template>
    <form @submit.prevent="$emit('on-submit')">
        <slot></slot>
    </form>
</template>

<script>
    import DirtyForm from './dirtyFormMixin'
    export default {
        name: 'BaseForm',
        mixins: [DirtyForm],
    }
</script>

<style lang="scss" scoped>

</style>