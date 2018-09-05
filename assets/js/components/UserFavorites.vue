<template>
    <div class="UserFavorites">
        {{ favorites }}
    </div>
</template>

<script>
    export default {
        name: 'UserFavorites',
        data () {
            return {
                favorites: []
            }
        },
        mounted () {
            this.favorites = JSON.parse(this.$el.dataset.favorites)
            delete this.$el.dataset.favorites;
            console.log(this.$el.dataset)
        }
    }
</script>

<style lang="scss" scoped>

</style>