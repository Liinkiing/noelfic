import actions from "./actions";
import mutations from "./mutations";

const state = {
    user: null,
    locale: 'en'
}

const getters = {


}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}