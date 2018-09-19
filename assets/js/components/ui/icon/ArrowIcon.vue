<template>
    <svg :width="width" :height="height" xmlns="http://www.w3.org/2000/svg" class="arrow-icon" :class="direction" :viewBox="viewBox">
        <g :fill="color">
            <polygon transform="translate(5.025000, 5.000000) scale(1, -1) translate(-5.025000, -5.000000)"
                     points="4.16666667 10 4.16666672 3.33333333 1.25 6.25 0.05 5 5.00000005 0 9.99999967 5 8.75 6.25 5.83333338 3.33333333 5.83333333 10"></polygon>
        </g>
    </svg>
</template>

<script>
    export default {
        name: 'ArrowIcon',
        props: {
            direction: {
                type: String,
                validator: input => ['top', 'left', 'right', 'bottom'].includes(input),
                default: 'top'
            },
            viewBox: {type: String, default: '-2 -3 15 15'},
            color: {type: String, default: 'currentColor'},
            width: {type: [Number, String], default: 10},
            height: {type: [Number, String], default: 10},
        }
    }
</script>

<style lang="scss" scoped>
    .arrow-icon {
        fill: currentColor;
        &.top {
            transform: rotate(-180deg);
        }
        &.left {
            transform: rotate(90deg);
        }
        &.right {
            transform: rotate(-90deg);
        }
        &.bottom {
            transform: rotate(0);
        }
    }
</style>