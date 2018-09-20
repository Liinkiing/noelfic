<template>
    <ApolloQuery :query="require('../../graphql/queries/FictionUserFavoriteQuery.graphql')" :variables="{fictionId}">
        <template slot-scope="{result, loading, gqlError}">
            <ApolloMutation
                    v-if="result && result.data && result.data.fiction.viewerHasFavorited"
                    :mutation="require('../../graphql/mutations/DeleteFictionUserFavoriteMutation.graphql')"
                    :variables="{input: {fictionId}}"
            >
                <template slot-scope="{mutate, loading, gqlError}">
                    <button :disabled="loading" @click="mutate">Supprimer</button>
                </template>
            </ApolloMutation>
            <ApolloMutation
                    v-else-if="result && result.data && !result.data.fiction.viewerHasFavorited"
                    :mutation="require('../../graphql/mutations/AddFictionUserFavoriteMutation.graphql')"
                    :variables="{input: {fictionId}}"
            >
                <template slot-scope="{mutate, loading, gqlError}">
                    <button :disabled="loading" @click="mutate">Ajouter</button>
                </template>
            </ApolloMutation>
        </template>
    </ApolloQuery>
</template>

<script>
    export default {
        name: "FictionUserFavorite",
        props: {
            fictionId: {type: String, required: true}
        }
    }

</script>

<style scoped>

</style>