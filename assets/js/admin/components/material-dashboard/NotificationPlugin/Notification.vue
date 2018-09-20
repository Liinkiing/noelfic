<template>
    <transition name="fade-up" appear>
        <div v-if="show"
             @after-leave="afterLeave"
             @click="close"
             data-notify="container"
             class="alert open alert-with-icon"
             role="alert"
             :class="[verticalAlign, horizontalAlign, alertType]"
             data-notify-position="top-center">
            <button
                    type="button"
                    aria-hidden="true"
                    class="close"
                    data-notify="dismiss"
                    @click="close">×
            </button>
            <i v-if="icon" data-notify="icon" :class="icon"></i>
            <span data-notify="message" v-html="message"></span>
        </div>
    </transition>
</template>
<script>
    export default {
        name: 'notification',
        props: {
            message: String,
            icon: String,
            verticalAlign: {
                type: String,
                default: 'top'
            },
            horizontalAlign: {
                type: String,
                default: 'center'
            },
            type: {
                type: String,
                default: 'info'
            },
            timeout: {
                type: Number,
                default: 4500
            },
            timestamp: {
                type: Date,
                default: () => new Date()
            }
        },
        data() {
            return {
                show: true,
                elmHeight: 0
            }
        },
        computed: {
            hasIcon() {
                return this.icon && this.icon.length > 0
            },
            alertType() {
                return `alert-${this.type}`
            },
            customPosition() {
                let initialMargin = 20
                let alertHeight = this.elmHeight + 10
                let sameAlertsCount = this.$notifications.state.filter((alert) => {
                    return alert.horizontalAlign === this.horizontalAlign && alert.verticalAlign === this.verticalAlign && alert.timestamp <= this.timestamp
                }).length
                let pixels = (sameAlertsCount - 1) * alertHeight + initialMargin
                let styles = {}
                if (this.verticalAlign === 'top') {
                    styles.top = `${pixels}px`
                } else {
                    styles.bottom = `${pixels}px`
                }
                return styles
            }
        },
        methods: {
            afterLeave() {
                this.$el.remove()
            },
            close() {
                this.$emit('on-close', this.timestamp)
                this.show = false
            }
        },
        mounted() {
            this.elmHeight = this.$el.clientHeight
            if (this.timeout) {
                setTimeout(this.close, this.timeout)
            }
        }
    }

</script>
<style lang="scss" scoped>
    @media screen and (max-width: 991px) {
        .alert {
            width: auto !important;
            margin: 0 10px;

            &.left {
                left: 0 !important;
            }
            &.right {
                right: 0 !important;
            }
            &.center {
                margin: 0 10px !important;
            }
        }
    }

    .alert {
        z-index: 100;
        cursor: pointer;
        position: absolute;
        width: 41%;
        top: 20px;
        &.center {
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            margin: 0 auto;

        }
        &.left {
            left: 20px;
        }
        &.right {
            right: 20px;
        }

    }

</style>
