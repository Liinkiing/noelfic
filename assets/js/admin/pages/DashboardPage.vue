<template>
    <AdminLayout>
        <h1>Dashboard</h1>
        <DashboardPageCharts v-if="charts" :charts="charts"/>
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
    import DashboardPageCharts from "../components/DashboardPageCharts";
    export default {
        name: 'DashboardPage',
        components: {
            DashboardPageCharts,
            Notification, DashboardPageBestFictions, OrderedTable, DashboardPageStats, AdminLayout},
        props: {
            stats: {type: Object, default: null},
            charts: {type: Object, default: null},
            bestFictions: {type: Object},
        }
    }
</script>

<style lang="scss" scoped>

</style>