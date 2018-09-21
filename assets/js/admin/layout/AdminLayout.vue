<template>
    <div class="wrapper" :class="{'nav-open': $sidebar.showSidebar}">
        <notifications></notifications>

        <div class="main-panel">
            <slot name="header"></slot>
            <div class="content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminSidebar from "./AdminSidebar";

    export default {
        name: 'AdminLayout',
        components: {AdminSidebar},
    }
</script>

<style lang="scss" scoped>

</style>