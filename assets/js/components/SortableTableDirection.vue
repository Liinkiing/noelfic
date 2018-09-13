<template>
    <span class="field-direction">
        <i class="fa fa-arrow-up"
           :class="{'hidden': direction === 'none', 'reverse': direction === 'desc'}"></i>
    </span>
</template>

<script>
    export default {
        name: "SortableTableDirection",
        props: {
            direction: {type: String, required: true, default: 'none'}
        }
    }
</script>

<style lang="scss" scoped>
    .field-direction {
        & i {
            transition: all .3s;
            transform: scale(1);
            opacity: 1;
            &.hidden {
                opacity: 0;
                transform: scale(0.9);
            }
            &.reverse {
                transform: rotate(-180deg);
            }
        }
    }
</style>