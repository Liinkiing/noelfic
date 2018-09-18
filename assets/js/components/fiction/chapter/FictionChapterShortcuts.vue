<template>
    <div>
        <FictionChapterShortcutsModal :can-go-next="canGoNext"
                                      :can-go-prev="canGoPrev"
                                      :show="showModal"
                                      @next="next"
                                      @prev="prev"
                                      @close="closeTutorialModal"/>
        <span class="help-icon">
            <i class="fa fa-question-circle-o" @click="showTutorialModal"></i>
        </span>
    </div>
</template>

<script>
    import {LS_TUTORIAL_SHORTCUT} from "../../../constants";
    import FictionChapterShortcutsModal from "../../ui/modals/FictionChapterShortcutsModal";

    export default {
        name: 'FictionChapterShortcuts',
        components: {FictionChapterShortcutsModal},
        data() {
            return {
                showModal: false,
                canGoPrev: false,
                canGoNext: true,
            }
        },
        methods: {
            initElements() {
                this._$pagination = document.querySelector('ul.pagination')
                this._$prev = this._$pagination.querySelector('li.page-item.prev')
                this._$next = this._$pagination.querySelector('li.page-item.next')
            },
            handleKey(e) {
                if (e.keyCode === 37) {
                    this.prev()
                } else if (e.keyCode === 39) {
                    this.next()
                }
            },
            showTutorialModal() {
                this.showModal = true
            },
            closeTutorialModal() {
                this.showModal = false
                localStorage.setItem(LS_TUTORIAL_SHORTCUT, 'read')
            },
            next() {
                if (!this.canGoNext) return
                this.closeTutorialModal()
                this._$next.querySelector('a').click()
            },
            prev() {
                if (!this.canGoPrev) return
                this.closeTutorialModal()
                this._$prev.querySelector('a').click()
            }
        },
        mounted() {
            this.initElements()
            this.showModal = localStorage.getItem(LS_TUTORIAL_SHORTCUT) !== 'read'
            this.canGoPrev = !this._$prev.classList.contains('disabled')
            this.canGoNext = !this._$next.classList.contains('disabled')
            this.handleKey = this.handleKey.bind(this)
            window.addEventListener('keyup', this.handleKey)
        },
        destroyed() {
            window.removeEventListener('keyup', this.handleKey)
        }
    }
</script>

<style lang="scss" scoped>
    .help-icon {
        transition: opacity $defaultTransitionDuration;
        opacity: 0.5;
        float: right;
        & i {
            transform: scale(0.6);
        }
        &:hover {
            opacity: 1;
            cursor: pointer;
        }
    }

    .keyboard-icon {
        filter: drop-shadow(0 19px 20px rgba(0, 0, 0, 0.3));
    }
</style>
