<template>
    <AdminLayout>
        <FictionForm v-if="fiction" :fiction="fiction"/>
    </AdminLayout>
</template>

<script>
    import AdminLayout from "../../layout/AdminLayout";
    import FictionForm from "./FictionForm";
    export default {
        name: 'FictionEditPage',
        components: {FictionForm, AdminLayout},
        props: {
            fictionId: {type: String, required: true}
        },
        apollo: {
            fiction: {
                query: require('../../graphql/queries/FictionEditPageQuery.graphql'),
                variables() {
                    const { fictionId } = this
                    return { fictionId }
                },
                update: data => data.node
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>