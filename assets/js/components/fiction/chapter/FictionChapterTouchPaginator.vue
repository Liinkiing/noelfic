<template>
    <v-touch class="touch-paginator-container" :options="{touchAction: 'pan-y'}" @swipeleft="next" @swiperight="prev">
        <transition name="fade-up" appear @after-enter="afterEnter">
            <FictionChapterTouchPaginatorIndicator v-if="hasSwiped" :swipe-direction="swipeDirection"/>
        </transition>
        <slot></slot>
    </v-touch>
</template>

<script>
    import FictionChapterTouchPaginatorIndicator from "./FictionChapterTouchPaginatorIndicator";

    export default {
        name: "FictionChapterTouchPaginator",
        components: {FictionChapterTouchPaginatorIndicator},
        data() {
            return {
                hasSwiped: false,
                swipeDirection: 'left'
            }
        },
        mounted() {
            this.initElements()
        },
        computed: {
            canGoPrev() {
                return !this._$prev.classList.contains('disabled')
            },
            canGoNext() {
                return !this._$next.classList.contains('disabled')
            }
        },
        methods: {
            initElements() {
                this._$pagination = document.querySelector('ul.pagination')
                this._$prev = this._$pagination.querySelector('li.page-item.prev')
                this._$next = this._$pagination.querySelector('li.page-item.next')
            },
            afterEnter() {
                if (this.swipeDirection === 'left') {
                    this._$prev.querySelector('a').click()
                } else if(this.swipeDirection === 'right') {
                    this._$next.querySelector('a').click()
                }
            },
            prev() {
                if (!this.canGoPrev) return;
                this.hasSwiped = true
                this.swipeDirection = 'left'
            },
            next() {
                if (!this.canGoNext) return;
                this.hasSwiped = true
                this.swipeDirection = 'right'
            }
        }
    }
</script>

<style lang="scss" scoped>
    .touch-paginator-container {
        position: relative;
    }

    .touch-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>