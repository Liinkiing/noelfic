<template>
    <div class="wrapper" :class="{'nav-open': $sidebar.showSidebar}">
        <notifications></notifications>

        <div class="main-panel">
            <slot name="header"></slot>
            <div class="content">
                <slot></slot>
            </div>
            <slot name="footer">
                <footer class="footer">
                    <div class="container">
                        <nav>
                            <ul>
                                <li><a href="/" class="nav-item active router-link-active">
                                    {{ $t('admin.navigation.back_site') }}
                                </a></li>
                            </ul>
                        </nav>
                    </div>
                </footer>
            </slot>
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