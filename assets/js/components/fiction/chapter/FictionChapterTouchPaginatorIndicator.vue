<template>
    <div class="touch-paginator-indicator">
        <ArrowIcon width="120" height="120" class="direction-indicator" :direction="swipeDirection"></ArrowIcon>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'
    import ArrowIcon from "../../ui/icon/ArrowIcon";
    import {FROZE_BODY, UNFROZE_BODY} from "../../../store/modules/app/actions";
    export default {
        name: 'FictionChapterTouchPaginatorIndicator',
        components: {ArrowIcon},
        props: {
            swipeDirection: {type: String, required: true, validator: input => ['left', 'right'].includes(input)}
        },
        methods: {
            ...mapActions('app', [FROZE_BODY, UNFROZE_BODY])
        },
        mounted() {
            this[FROZE_BODY]()
        },
        beforeDestroy() {
            this[UNFROZE_BODY]()
        }
    }
</script>

<style lang="scss" scoped>
    .touch-paginator-indicator {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        background: transparentize(white, 0.15);
        backdrop-filter: blur(10px)
    }
</style>