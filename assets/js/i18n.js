import Vue from "vue"
import moment from "moment"
import vueMoment from "vue-moment"
import VueI18n from "vue-i18n"

const locale = window.location.pathname.split('/').filter(Boolean).shift()
moment.locale(locale)
moment.defaultFormat = 'LLL'

Vue.use(VueI18n)
Vue.use(vueMoment, {moment})

Vue.prototype.$tc = (id, number, parameters = {}, domain, locale) => {
    return Translator.transChoice(id, number, parameters, domain, locale)
}
Vue.prototype.$t = (id, parameters = {}, domain, locale) => {
    return Translator.trans(id, parameters, domain, locale)
}

export default new VueI18n({
    locale: locale,
    fallbackLocale: 'en',
    messages: {}
})

// import(`../../translations/messages.${locale}.json`).then(messages => {
//     i18n.setLocaleMessage(locale, messages)
// })