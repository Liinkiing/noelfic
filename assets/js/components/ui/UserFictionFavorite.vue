<template>
    <div class="user-fiction card" >
        <a :href="$routing.generate('fiction.show', {slug: fictionFavorite.fiction.slug})">
            {{ fictionFavorite.fiction.title }}
        </a>
        <FictionUserFavorite
                class="fiction-user-favorite"
                :fiction-id="fictionFavorite.fiction.id"
                :refetch-queries="refetchQueries"
        />
    </div>
</template>

<script>
    import FictionUserFavorite from "../fiction/FictionUserFavorite";
    export default {
        name: "UserFictionFavorite",
        components: {FictionUserFavorite},
        props: {
            refetchQueries: {type: Function, default: () => []},
            fictionFavorite: {type: Object, required: true}
        }
    }
</script>

<style lang="scss" scoped>
    .user-fiction.card {
        transition: all $defaultTransitionDuration;
        box-shadow: $commentBoxShadow;
        background: white;
        width: 200px;
        margin: 10px;
        padding: 10px;
        &:hover {
            background: darken(white, 5%);
            cursor: pointer;
        }
        & .fiction-user-favorite {
            z-index: 1;
        }
    }
</style>