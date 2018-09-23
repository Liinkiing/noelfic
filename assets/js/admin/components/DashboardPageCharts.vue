<template>
    <transition name="fade-up" appear>
        <div class="row">
            <div class="col col-lg-4" v-for="(entity, i) in Object.keys(charts)" :key="i">
            </div>
        </div>
    </transition>
</template>

<script>
    import ChartCard from "./material-dashboard/Cards/ChartCard";
    export default {
        name: 'DashboardPageCharts',
        components: {ChartCard},
        props: {
            charts: {type: Object}
        },
        mounted() {
            console.log(this.charts)
        }
    }
</script>

<style lang="scss" scoped>

</style>