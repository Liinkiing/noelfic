<template>
    <md-field>
        <label v-text="$t(label)"></label>
        <md-input :name="name"
                  @input="$emit('input', $event)"
                  :value="value"
                  v-validate="validationRules"
                  :data-vv-as="$t(label)"></md-input>
        <span class="text-danger">{{ errors.first(name) }}</span>
    </md-field>
</template>

<script>
    export default {
        name: 'TextField',
        props: {
            label: {type: String, default: ''},
            validationRules: {type: String, default: null},
            name: {type: String, required: true},
            value: {type: String, default: ''}
        },
        methods: {
        }
    }
</script>

<style lang="scss" scoped>

</style>