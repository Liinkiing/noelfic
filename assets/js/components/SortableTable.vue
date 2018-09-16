<template>
    <table class="table">
        <thead>
        <tr>
            <th v-for="column in columns" :key="column" @click="changeDirection(column)">
                <span>{{ $t(column) }}</span>
                <sortable-table-direction :direction="directions[column]"></sortable-table-direction>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(row, index) in sorted" :key="index">
            <td v-for="column in columns" :key="column" v-html="row[column]">
                {{ row[column] }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import SortableTableDirection from "./SortableTableDirection"
    import { orderBy } from 'lodash-es'

    export default {
        name: "SortableTable",
        components: {SortableTableDirection},
        props: {
            columns: {type: Array, required: true, default: () => []},
            rows: {type: Array, required: true, default: () => []}
        },
        data() {
            return {
                directions: {

                }
            }
        },
        computed: {
          sorted() {
            const columns = Object.keys(this.directions).reduce((acc, curr) => {
                if(['asc', 'desc'].includes(this.directions[curr])) {
                    acc.push(curr)
                    return acc
                }
                return acc
            }, [])
              const directions = columns.map(column => this.directions[column])
              return orderBy(this.rows, columns, directions)
          }
        },
        methods: {
            changeDirection(column) {
                switch (this.directions[column]) {
                    case 'none':
                        this.directions[column] = 'asc'
                        break
                    case 'asc':
                        this.directions[column] = 'desc'
                        break
                    case 'desc':
                        this.directions[column] = 'none'
                        break
                    default:
                        this.directions[column] = 'none'
                        break
                }
            }
        },
        beforeMount() {
            this.columns.forEach(column => {
                this.$set(this.directions, column, 'none')
            })
        }
    }
</script>

<style lang="scss" scoped>
    thead th {
        transition: all .3s;
        user-select: none;
        &:hover {
            cursor: pointer;
            background: transparentize(black, 0.9);
        }
        & .field-direction {
            float: right;
        }
    }
</style>