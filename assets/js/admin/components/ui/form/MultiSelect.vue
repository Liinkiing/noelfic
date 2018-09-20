<template>
    <ApolloQuery class="multi-select" :query="query">
        <template slot-scope="{ result, loading, gqlError }">
            <Loader with-background absolute size="medium" v-if="loading"></Loader>
            <md-field v-if="result && result.data && result.data.items">
                <label :for="name">{{ $t(label) }}</label>
                <md-select v-model="selected" :name="name" :id="name" multiple @md-selected="$emit('md-selected', selected)">
                    <md-option v-for="(item, i) in result.data.items" :key="item.id ? item.id : i" :value="item.id ? item.id : i">
                        <slot :item="item" :index="i">
                            {{ item.title }}
                        </slot>
                    </md-option>
                </md-select>
            </md-field>
        </template>
    </ApolloQuery>
</template>


<script>
    import Loader from "../../../../components/ui/Loader";
    export default {
        name: 'MultiSelect',
        components: {Loader},
        props: {
            query: {type: Object, required: true},
            label: {type: String, default: ''},
            initalValues: {type: Array, default: () => []},
            name: {type: String, required: true},
        },
        data() {
            return {
                selected: [],
            }
        },
        mounted() {
            this.selected = this.initalValues;
        }
    }
</script>

<style lang="scss" scoped>
    .multi-select {

    }
</style>