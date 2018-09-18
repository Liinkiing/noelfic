<template>
    <div>
        <transition name="fade-up">
            <modal modal-classes="modal-info" v-if="showModal" :show="showModal" gradient="primary" @close="closeTutorialModal">
                <template slot="header">
                    {{ $t('modal.fiction.chapter.shortcut.title') }}
                </template>
                <div class="text-center">
                    <icon-base class="keyboard-icon" height="260" width="260" view-box="-7 42 160 18">
                        <icon-keyboard/>
                    </icon-base>
                </div>
                <p class="text-center">
                    <key-code class="mr-4" code="37"/>
                    {{ $t('or') }}
                    <key-code class="ml-4" code="39"/>
                    <span class="ml-4">
                    {{ $t('modal.fiction.chapter.shortcut.change_chapter') }}
                </span>
                </p>
                <template slot="footer">
                    <base-button type="secondary" @click="closeTutorialModal">
                        {{ $t('modal.fiction.chapter.shortcut.undersood') }}
                    </base-button>
                </template>
            </modal>
        </transition>
        <span class="help-icon">
            <i class="fa fa-question-circle-o" @click="showTutorialModal"></i>
        </span>
    </div>
</template>

<script>
    import Modal from "vue-argon-design-system/src/components/Modal";
    import KeyCode from "../../ui/KeyCode";
    import IconKeyboard from "../../ui/icon/icons/IconKeyboard";
    import {LS_TUTORIAL_SHORTCUT} from "../../../constants";

    export default {
        name: 'FictionChapterShortcuts',
        components: {IconKeyboard, KeyCode, Modal},
        data() {
            return {
                showModal: false,
            }
        },
        methods: {
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
                if (this._$next.classList.contains('disabled')) return
                this.closeTutorialModal()
                this._$next.querySelector('a').click()
            },
            prev() {
                if (this._$prev.classList.contains('disabled')) return
                this.closeTutorialModal()
                this._$prev.querySelector('a').click()
            }
        },
        mounted() {
            this.showModal = localStorage.getItem(LS_TUTORIAL_SHORTCUT) !== 'read'
            this._$pagination = document.querySelector('ul.pagination')
            this._$prev = this._$pagination.querySelector('li.page-item.prev')
            this._$next = this._$pagination.querySelector('li.page-item.next')
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
