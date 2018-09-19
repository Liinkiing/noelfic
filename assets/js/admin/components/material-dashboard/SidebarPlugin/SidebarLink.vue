<template>
    <md-list-item @click="hideSidebar"
                  v-bind="$attrs">
        <slot>
            <i v-if="link.icon" :class="link.icon"></i>
            <p>{{$t(link.name)}}</p>
        </slot>
    </md-list-item>
</template>
<script>
    export default {
        inject: {
            autoClose: {
                default: true
            }
        },
        props: {
            active: {
                type: Boolean,
                default: false
            },
            link: {
                type: [String, Object],
                default: () => {
                    return {
                        name: '',
                        path: '',
                        icon: ''
                    }
                }
            },
            tag: {
                type: String,
                default: 'a'
            }
        },
        mounted() {
            if (this.active){
                this.$el.querySelector('a').classList.add('active')
            }
        },
        methods: {
            hideSidebar() {
                if (this.autoClose && this.$sidebar && this.$sidebar.showSidebar === true) {
                    this.$sidebar.displaySidebar(false)
                }
            }
        }
    }
</script>
<style>
</style>
