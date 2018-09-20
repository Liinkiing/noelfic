<template>
    <AdminLayout>
        <DashboardPageStats v-if="stats" :stats="stats"/>
        <DashboardPageBestFictions :best-fictions="bestFictions"/>
    </AdminLayout>
</template>

<script>
    import AdminLayout from "../layout/AdminLayout";
    import DashboardPageStats from "../components/DashboardPageStats";
    import OrderedTable from "../components/material-dashboard/Tables/OrderedTable";
    import DashboardPageBestFictions from "../components/DashboardPageBestFictions";
    import Notification from "../components/material-dashboard/NotificationPlugin/Notification";
    export default {
        name: 'DashboardPage',
        components: {Notification, DashboardPageBestFictions, OrderedTable, DashboardPageStats, AdminLayout},
        props: {
            stats: {type: Object, default: null},
            bestFictions: {type: Object},
        }
    }
</script>

<style lang="scss" scoped>

</style>