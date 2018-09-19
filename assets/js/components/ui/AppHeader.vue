<template>
    <base-nav class="main-navigation" :title="sitename" type="primary" expand>
        <template slot="brand">
            <i v-if="!isHomepage" class="fa fa-angle-left fa-2x back-icon" @click="prev"></i>
            <a class="navbar-brand" :href="homepage">
                {{ sitename }}
            </a>
        </template>
        <LoginModal :csrf-token="csrfToken" :show="showLoginModal" @close="hideLogin"/>
        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item" v-for="link in links">
                <a :href="link.href" class="nav-link" v-if="link.id !== 'login'">
                    {{ $t(link.name, link.params) }}
                </a>
                <a v-else href="#" class="nav-link" @click="showLogin">
                    {{ $t(link.name, link.params) }}
                </a>
            </li>
        </ul>
    </base-nav>
</template>

<script>
    import { mapState } from 'vuex'
    import BaseNav from "vue-argon-design-system/src/components/BaseNav"
    import LoginModal from "./modals/LoginModal"
    export default {
        name: 'AppHeader',
        components: {LoginModal, BaseNav},
        props: {
            csrfToken: {type: String},
            homepage: {type: String, required: true, default: '/'},
            sitename: {type: String, required: true, default: 'Noelfic'},
            links: {type: Array, required: true, default: []},
        },
        data() {
            return {
                showLoginModal: false
            }
        },
        computed: {
            ...mapState('app', ['isHomepage'])
        },
        methods: {
            showLogin() {
                this.showLoginModal = true
            },
            hideLogin() {
                this.showLoginModal = false
            },
            prev() {
                window.history.back()
            }
        },
        mounted() {
            const renderedNav = document.getElementById('renderedNav')
            if(renderedNav) {
                renderedNav.remove()
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>