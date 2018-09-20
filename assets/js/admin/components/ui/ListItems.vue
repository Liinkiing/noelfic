<template>
    <ul class="list-items-container">
        <li class="list-item" v-for="(item,i) in items" :key="item.id ? item.id : i">
            <slot :item="item" :index="i">
                {{ item }}
            </slot>
        </li>
    </ul>
</template>

<script>

    export default {
        name: 'ListItems',
        props: {
            items: {type: Array, required: true}
        }
    }
</script>

<style lang="scss" scoped>
</style>