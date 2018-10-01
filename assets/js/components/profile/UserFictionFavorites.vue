<template>
    <transition name="fade-up" appear>
        <ApolloQuery :query="require('../../graphql/queries/UserFictionFavoritesQuery.graphql')">
            <template slot-scope="{ result, loading, gqlError }" v-if="result && result.data">
                <div class="user-fiction-favorites">
                    <h1 v-text="$tc('global.fictionFavoritesCount', result.data.viewer.fictionFavorites.totalCount)"></h1>
                    <transition-group name="list" appear class="favorites" tag="div">
                        <UserFictionFavorite
                                class="list-item"
                                :refetch-queries="() => ['UserFictionFavoritesQuery']"
                                v-for="fictionFavorite in result.data.viewer.fictionFavorites.edges.map(edge => edge.node)"
                                :key="fictionFavorite.id"
                                :fiction-favorite="fictionFavorite"/>
                    </transition-group>
                </div>
            </template>
        </ApolloQuery>
    </transition>
</template>

<script>
    import UserFictionFavorite from "../ui/UserFictionFavorite";

    export default {
        name: "UserFictionFavorites",
        components: {UserFictionFavorite}
    }
</script>

<style lang="scss" scoped>
    .favorites {
        display: flex;
        flex-wrap: wrap;
    }

    .list-item {
        transition: all 0.3s;
        display: inline-flex;
    }

    .list-enter, .list-leave-to {
        opacity: 0;
        transform: translateY(30px);
    }

    .list-leave-active {
        position: absolute;
    }
</style>