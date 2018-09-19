<template>
    <side-bar :title="sitename" :sidebar-links="links"></side-bar>
</template>

<script>
    export default {
        name: 'AdminSidebar',
        props: {
            homepage: {type: String, default: '/'},
            sitename: {type: String, default: 'Noelfic'},
            links: {type: Array, default: []},
        }
    }
</script>

<style lang="scss" scoped>

</style>