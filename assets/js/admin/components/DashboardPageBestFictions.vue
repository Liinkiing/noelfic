<template>
    <transition name="fade-up" appear>
        <div class="row">
            <div class="col-xs-12">
                <md-card>
                    <md-card-header :data-background-color="bestFictions.color">
                        <h4 class="title" v-text="$t(bestFictions.name)"></h4>
                        <p class="category" v-text="$t(bestFictions.subtitle)"></p>
                    </md-card-header>
                    <md-card-content>
                        <md-table v-model="bestFictions.items" :table-header-color="bestFictions.color">
                            <md-table-row slot="md-table-row" slot-scope="{ item }">
                                <md-table-cell :md-label="$t('fiction.table.heading.id')">{{ item.id }}</md-table-cell>
                                <md-table-cell :md-label="$t('fiction.table.heading.name')">
                                    <a :href="$routing.generate('fiction.show', {slug: item.slug})">
                                        {{ item.title }}
                                    </a>
                                </md-table-cell>
                                <md-table-cell :md-label="$t('fiction.table.heading.averageRating')">{{ item.average }}</md-table-cell>
                                <md-table-cell :md-label="$t('fiction.table.heading.slug')">{{ item.slug }}</md-table-cell>
                                <md-table-cell :md-label="$t('fiction.table.heading.createdAt')">{{ item.createdAt|moment }}</md-table-cell>
                                <md-table-cell :md-label="$t('fiction.table.heading.updatedAt')">{{ item.updatedAt|moment }}</md-table-cell>
                                <md-table-cell :md-label="$t('global.actions')">
                                    <!--<a :href=""></a>-->
                                </md-table-cell>
                            </md-table-row>
                        </md-table>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'DashboardPageBestFictions',
        props: {
            bestFictions: {type: Object}
        }
    }
</script>

<style lang="scss" scoped>

</style>