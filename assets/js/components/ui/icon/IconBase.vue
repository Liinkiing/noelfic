<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         :viewBox="viewBox"
         role="presentation"
    >
    <g :fill="color">
      <slot />
    </g>
  </svg>

</template>

<script>
    export default {
        props: {
            viewBox: {
                type: String,
                default: "0 0 18 18"
            },
            iconName: {
                type: String,
                default: 'box'
            },
            width: {
                type: [Number, String],
                default: 18
            },
            height: {
                type: [Number, String],
                default: 18
            },
            color: {
                type: String,
                default: 'currentColor'
            }
        }
    }
</script>

<style scoped>
    svg {
        display: inline-block;
        vertical-align: baseline;
        margin-bottom: -2px;
    }
</style>