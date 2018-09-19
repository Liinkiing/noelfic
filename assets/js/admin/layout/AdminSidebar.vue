<template>
    <side-bar class="admin-sidebar"
              :title="sitename"
              :sidebar-links="links"
              :footer-content="footerContent">
        <template slot="footer">
            <div class="language-picker" v-html="footerContent"></div>
        </template>
    </side-bar>
</template>

<script>
    export default {
        name: 'AdminSidebar',
        props: {
            homepage: {type: String, default: '/'},
            sitename: {type: String, default: 'Noelfic'},
            links: {type: Array, default: []},
            footerContent: {type: String, default: ''},
        }
    }
</script>

<style lang="scss">
    .language-picker {
        color: whitesmoke;
        & a {
            transition: all $defaultTransitionDuration;
            padding: 0.25rem;
            color: whitesmoke !important;
            text-decoration: none;
            opacity: 0.6;
            border-radius: $borderRadius;
            &:hover {
                cursor: pointer;
                opacity: 1;
                background: transparentize(white, 0.8);
            }
            &.active {
                opacity: 1;
                background: transparentize(white, 0.5);
            }
        }
    }
</style>