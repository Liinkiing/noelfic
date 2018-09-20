<template>
    <AdminLayout>
        <h1 v-text="$t('admin.fiction.new.title')"></h1>
        <FictionForm/>
    </AdminLayout>
</template>

<script>
    import AdminLayout from "../../layout/AdminLayout";
    import FictionForm from "../../components/ui/form/FictionForm";
    export default {
        name: 'FictionAddPage',
        components: {FictionForm, AdminLayout}
    }
</script>

<style lang="scss" scoped>

</style>