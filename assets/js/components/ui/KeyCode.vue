<template>
    <span class="key-code">
        <ArrowIcon v-if="['left', 'right', 'top', 'bottom'].includes(codeString)" :direction="codeString" class="text key-icon"/>
        <span v-else class="text">{{ codeString }}</span>
    </span>
</template>

<script>
    import {keyboardMap} from "../../constants";
    import ArrowIcon from "./icon/ArrowIcon";

    export default {
        name: 'KeyCode',
        components: {ArrowIcon},
        props: {
            code: {type: [String, Number], required: true}
        },
        computed: {
            codeString() {
                return keyboardMap[this.code].toLowerCase()
            }
        }
    }
</script>

<style lang="scss" scoped>
    .key-code {
        transition: all .1s;
        background: whitesmoke;
        border-radius: $borderRadius;
        border: 1px solid transparentize(black, 0.6);
        box-shadow: inset 0 -5px 0 transparentize(black, 0.86), $commentBoxShadowActive;
        color: transparentize(black, 0.3);
        cursor: pointer;
        user-select: none;
        padding: .5rem;
        text-transform: uppercase;
        font-weight: 700;
        font-size: .8rem;
        & .text {
            position: relative;
            transition: all .1s;
            top: -1px;
            &.key-icon {
                top: -3px;
            }
        }
        &:hover {
            background: darken(whitesmoke, 2%);
            box-shadow: inset 0 -5px 0 transparentize(black, 0.86), $keyCodeBoxShadow;
        }
        &:active {
            border: 1px solid transparentize(black, 0.4);
            padding-top: .25rem;
            box-shadow: inset 0 -2px 0 transparentize(black, 0.66), $activeKeyCodeBoxShadow;
            background: darken(whitesmoke, 3%);
            & .text {
                top: 2px;
                &.key-icon {
                    top: 0;
                }
            }
        }

    }
</style>