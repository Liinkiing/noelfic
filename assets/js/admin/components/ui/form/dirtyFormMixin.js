export default {
    computed: {
        isFormDirty() {
            return Object.keys(this.fields).some(key => this.fields[key].dirty);
        }
    }
}