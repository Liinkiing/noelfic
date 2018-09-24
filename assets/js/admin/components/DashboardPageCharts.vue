<template>
    <transition name="fade-up" appear>
        <div class="row">
            <div class="col col-lg-4" v-for="(entity, i) in Object.keys(charts)" :key="i">
                <chart-card :chart-data="charts[entity].data" :chart-options="charts[entity].options" :data-background-color="charts[entity].color">
                    <template slot="content">
                        <h4 class="title">{{charts[entity].title}}</h4>
                    </template>
                </chart-card>
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
    }
</script>

<style lang="scss" scoped>

</style>