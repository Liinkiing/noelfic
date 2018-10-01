<template>
    <div class="profile-page">
        <transition name="fade-up" appear>
            <ApolloQuery :query="require('../../graphql/queries/ProfilePageQuery.graphql')">
                <template slot-scope="{ result, loading, gqlError }" v-if="result && result.data">
                    <h1>{{ result.data.viewer.username }}</h1>
                    <UserFictionFavorites/>
                </template>
            </ApolloQuery>
        </transition>
    </div>
</template>

<script>
    import UserFictionFavorites from "../../components/profile/UserFictionFavorites";
    export default {
        name: "ProfilePage",
        components: {UserFictionFavorites}
    }
</script>

<style lang="scss" scoped>

</style>