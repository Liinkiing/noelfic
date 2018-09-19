import actions from "./actions";
import mutations from "./mutations";

const state = {
    user: null,
    locale: 'en',
    isTouchDevice: false,
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