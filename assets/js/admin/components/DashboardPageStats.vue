<template>
    <transition name="fade-up" appear>
        <div class="row">
            <div class="col col-lg-4" v-for="(entity, i) in Object.keys(stats)" :key="i">
                <stats-card :data-background-color="stats[entity].color">
                    <template slot="header">
                        <i :class="stats[entity].icon"></i>
                    </template>

                    <template slot="content">
                        <p class="category">{{ $t(stats[entity].name) }}</p>
                        <h3 v-text="stats[entity].count" class="title"></h3>
                    </template>
                </stats-card>
            </div>
        </div>
    </transition>
</template>

<script>
    import StatsCard from "./material-dashboard/Cards/StatsCard";
    export default {
        name: 'DashboardPageStats',
        components: {StatsCard},
        props: {
            stats: {type: Object}
        }
    }
</script>

<style lang="scss" scoped>

</style>