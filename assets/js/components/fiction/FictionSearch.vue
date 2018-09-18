<template>
    <form class="search-form" :action="formAction" method="get">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-6">
                <div class="form-group search-input">
                    <base-input :placeholder="$t('fiction.search.placeholder')"
                                alternative addon-left-icon="fa fa-search"
                                name="q" v-model="query"></base-input>
                    <base-button native-type="submit" icon="fa fa-search" type="success" icon-only></base-button>
                </div>
                <slide-y-up-transition>
                    <div v-show="showCategoriesFilters" class="row justify-content-center filters" :class="{'collapsed': showCategoriesFilters}">
                        <div class="col">
                            <h3 class="heading mb-2">{{ $t('fiction.filters.category') }}</h3>
                            <div v-for="category in categories"
                                 class="custom-control custom-checkbox custom-control-inline mb-3">
                                <input type="checkbox"
                                       :key="category.id"
                                       :id="category.slug"
                                       v-model="checkedCategoryFilters"
                                       name="c[]"
                                       :value="category.title"
                                       class="custom-control-input"/>
                                <label class="custom-control-label" :for="category.slug">
                                    <span>{{ category.title }}</span>
                                </label>
                            </div>

                        </div>
                    </div>
                </slide-y-up-transition>
            </div>
            <div class="col-lg-2 col-md-4 justify-content-center">
                    <base-button @click="toggleFilters" class="btn-filter" icon="fa fa-filter" type="primary" :class="{'reverse': showCategoriesFilters}">
                        {{ showCategoriesFilters ? $t('global.filters.hide') : $t('global.filters.show') }}
                    </base-button>
            </div>

        </div>
    </form>
</template>

<script>
    import {SlideYUpTransition} from 'vue2-transitions'

    export default {
        name: "FictionSearch",
        components: {SlideYUpTransition},
        props: {
            categories: {type: Array, required: true, default: []},
            formAction: {type: String, required: false, default: ""}
        },
        data() {
            return {
                showCategoriesFilters: false,
                query: '',
                checkedCategoryFilters: []
            }
        },
        computed: {
            queryParams() {
                return new URLSearchParams(window.location.search.substring(1))
            },
            disableSearch() {
                return this.query === '' && this.checkedCategoryFilters.length === 0
            }
        },
        methods: {
            toggleFilters() {
                this.showCategoriesFilters = !this.showCategoriesFilters
            }
        },
        mounted() {
            this.query = this.queryParams.get('q')
            this.checkedCategoryFilters = this.queryParams.getAll('c[]')
            this.showCategoriesFilters = this.checkedCategoryFilters.length > 0
        }
    }
</script>

<style lang="scss">
    form.search-form {
        transition: all .3s;
        margin-bottom: 1.25rem;
        & .search-input {
            position: relative;
            & button[type="submit"] {
                position: absolute;
                right: 4px;
                top: 4px;
            }
        }
        & .filters {
            transition: all .3s;
            overflow: hidden;
            max-height: 0;
            &.collapsed {
                max-height: 300px;
                overflow: visible;
            }
        }
        & .btn-filter {
            position: relative;
            top: 2px;
        }
        & .btn-icon i {
            transition: transform .3s;
        }
        & .btn-icon.reverse i {
            transform: scaleY(-1);
        }
    }
</style>