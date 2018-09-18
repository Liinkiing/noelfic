<template>
    <transition name="fade-up" appear>
        <div class="loader" :class="{'loader-inline': inline, absolute, 'with-background': withBackground, [size]: true}">
            <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                <g fill="none" fill-rule="evenodd" stroke-width="2">
                    <circle cx="22" cy="22" r="1">
                        <animate attributeName="r"
                                 begin="0s" dur="1.8s"
                                 values="1; 20"
                                 calcMode="spline"
                                 keyTimes="0; 1"
                                 keySplines="0.165, 0.84, 0.44, 1"
                                 repeatCount="indefinite" />
                        <animate attributeName="stroke-opacity"
                                 begin="0s" dur="1.8s"
                                 values="1; 0"
                                 calcMode="spline"
                                 keyTimes="0; 1"
                                 keySplines="0.3, 0.61, 0.355, 1"
                                 repeatCount="indefinite" />
                    </circle>
                    <circle cx="22" cy="22" r="1">
                        <animate attributeName="r"
                                 begin="-0.9s" dur="1.8s"
                                 values="1; 20"
                                 calcMode="spline"
                                 keyTimes="0; 1"
                                 keySplines="0.165, 0.84, 0.44, 1"
                                 repeatCount="indefinite" />
                        <animate attributeName="stroke-opacity"
                                 begin="-0.9s" dur="1.8s"
                                 values="1; 0"
                                 calcMode="spline"
                                 keyTimes="0; 1"
                                 keySplines="0.3, 0.61, 0.355, 1"
                                 repeatCount="indefinite" />
                    </circle>
                </g>
            </svg>
        </div>
    </transition>

</template>

<script>
    export default {
        name: "loader",
        props: {
            inline: {type: Boolean, required: false, default: false},
            absolute: {type: Boolean, required: false, default: false},
            size: {type: String, required: false, default: 'medium'},
            withBackground: {type: Boolean, required: false, default: false},
        }
    };
</script>

<style lang="scss" scoped>
    .loader {
        display: flex;
        justify-content: center;
        align-items: center;
        &.loader-inline {
            display: inline-flex;
        }
        &.with-background {
            background: transparentize(black, 0.6);
            border-radius: 2px;
        }
        &.absolute {
            position: absolute;
            z-index: 2;
            left: calc(50% - #{$smallLoaderWidth / 2});
            top: calc(45% - #{$smallLoaderWidth / 2});
        }
        &.small {
            padding: 4px;
            width: $smallLoaderWidth;
            height: $smallLoaderWidth;
            & svg {
                width: 100%;
                height: 100%;
            }
        }
        &.medium {
            padding: 8px;
            width: $mediumLoaderWidth;
            height: $mediumLoaderWidth;
            & svg {
                width: 100%;
                height: 100%;
            }
        }
        &.large {
            padding: 16px;
            width: $largeLoaderWidth;
            height: $largeLoaderWidth;
            & svg {
                width: 100%;
                height: 100%;
            }
        }
    }
</style>
