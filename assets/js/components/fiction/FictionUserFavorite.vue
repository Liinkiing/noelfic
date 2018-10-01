<template>
    <ApolloQuery tag="span" class="favorite" :query="require('../../graphql/queries/FictionUserFavoriteQuery.graphql')" :variables="{fictionId}">
        <template slot-scope="{result, loading, gqlError}">
            <ApolloMutation
                    v-if="result && result.data && result.data.fiction.viewerHasFavorited"
                    :mutation="require('../../graphql/mutations/DeleteFictionUserFavoriteMutation.graphql')"
                    :refetch-queries="refetchQueries"
                    :variables="{input: {fictionId}}"
                    :optimistic-response="{
                    __typename: 'Mutation',
                    deleteFictionUserFavorite: {
                            __typename: 'DeleteFictionUserFavoritePayload',
                            fiction: {
                                __typename: 'Fiction',
                                id: fictionId,
                                viewerHasFavorited: false
                            }
                        }
                    }"
                    tag="span"
            >
                <template slot-scope="{mutate, loading, gqlError}">
                    <button class="btn-favorite delete-favorite fa fa-star" :disabled="loading" @click.self="mutate"></button>
                </template>
            </ApolloMutation>
            <ApolloMutation
                    v-else-if="result && result.data && !result.data.fiction.viewerHasFavorited"
                    :mutation="require('../../graphql/mutations/AddFictionUserFavoriteMutation.graphql')"
                    :refetch-queries="refetchQueries"
                    :variables="{input: {fictionId}}"
                    :optimistic-response="{
                    __typename: 'Mutation',
                    addFictionUserFavorite: {
                            __typename: 'AddFictionUserFavoritePayload',
                            fiction: {
                                __typename: 'Fiction',
                                id: fictionId,
                                viewerHasFavorited: true
                            }
                        }
                    }"
                    tag="span"
            >
                <template slot-scope="{mutate, loading, gqlError}">
                    <button class="btn-favorite add-favorite fa fa-star" :disabled="loading" @click.self="mutate"></button>
                </template>
            </ApolloMutation>
        </template>
    </ApolloQuery>
</template>

<script>
    export default {
        name: "FictionUserFavorite",
        props: {
            refetchQueries: {type: Function, default: () => []},
            fictionId: {type: String, required: true}
        }
    }

</script>

<style lang="scss" scoped>
    .btn-favorite {
        background: transparent;
        transition: all $defaultTransitionDuration;
        &:hover {
            cursor: pointer;
        }
    }
    .add-favorite {
        color: grey;
        border: none;
        transition: all $defaultTransitionDuration;
        &:hover {
            color: darken(grey, 15%)
        }
    }
    .delete-favorite {
        color: #ffe533;
        border: none;
        transition: all $defaultTransitionDuration;
        &:hover {
            color: darken(#ffe533, 15%)
        }
    }
</style>