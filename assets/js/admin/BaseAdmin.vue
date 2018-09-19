<template>
    <div class="root-admin">
        <div class="main-panel">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    import AdminHeader from "./layout/AdminSidebar";
    export default {
        name: 'BaseAdmin',
        components: {AdminHeader}
    }
</script>