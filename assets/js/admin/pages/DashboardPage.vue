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
    export default {
        name: 'DashboardPage',
        components: {DashboardPageBestFictions, OrderedTable, DashboardPageStats, AdminLayout},
        props: {
            stats: {type: Object, default: null},
            bestFictions: {type: Object},
        }
    }
</script>

<style lang="scss" scoped>

</style>