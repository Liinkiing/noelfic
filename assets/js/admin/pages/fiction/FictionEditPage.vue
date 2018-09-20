<template>
    <AdminLayout>
        <h1 v-if="fiction" v-text="$t('admin.fiction.edit.title', {title: fiction.title})"></h1>
        <FictionForm v-if="fiction" :fiction="fiction"/>
    </AdminLayout>
</template>

<script>
    import AdminLayout from "../../layout/AdminLayout";
    import FictionForm from "../../components/ui/form/FictionForm";
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