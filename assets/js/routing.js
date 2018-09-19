import Vue from "vue";
import {locale} from "./i18n";

Vue.prototype.$routing = Routing

// Modified generate method taken from here to take in account _locale parameter
// https://github.com/FriendsOfSymfony/FOSJsRoutingBundle/blob/master/Resources/js/router.js

Vue.prototype.$routing.generate = function(name, opt_params, absolute = false) {
    let route = (this.getRoute(name)),
        params = Object.assign({'_locale': locale}, opt_params) || {},
        unusedParams = Object.assign({}, params),
        url = '',
        optional = true,
        host = '';

    route.tokens.forEach((token) => {
        if ('text' === token[0]) {
            url = token[1] + url;
            optional = false;

            return;
        }

        if ('variable' === token[0]) {
            let hasDefault = route.defaults && (token[3] in route.defaults);
            if (false === optional || !hasDefault || ((token[3] in params) && params[token[3]] != route.defaults[token[3]])) {
                let value;

                if (token[3] in params) {
                    value = params[token[3]];
                    delete unusedParams[token[3]];
                } else if (hasDefault) {
                    value = route.defaults[token[3]];
                } else if (optional) {
                    return;
                } else {
                    throw new Error('The route "' + name + '" requires the parameter "' + token[3] + '".');
                }

                let empty = true === value || false === value || '' === value;

                if (!empty || !optional) {
                    let encodedValue = encodeURIComponent(value).replace(/%2F/g, '/');

                    if ('null' === encodedValue && null === value) {
                        encodedValue = '';
                    }

                    url = token[1] + encodedValue + url;
                }

                optional = false;
            } else if (hasDefault && (token[3] in unusedParams)) {
                delete unusedParams[token[3]];
            }

            return;
        }

        throw new Error('The token type "' + token[0] + '" is not supported.');
    });

    if (url === '') {
        url = '/';
    }

    route.hosttokens.forEach((token) => {
        let value;

        if ('text' === token[0]) {
            host = token[1] + host;

            return;
        }

        if ('variable' === token[0]) {
            if (token[3] in params) {
                value = params[token[3]];
                delete unusedParams[token[3]];
            } else if (route.defaults && (token[3] in route.defaults)) {
                value = route.defaults[token[3]];
            }

            host = token[1] + value + host;
        }
    });
    // Foo-bar!
    url = this.context_.base_url + url;
    if (route.requirements && ("_scheme" in route.requirements) && this.getScheme() != route.requirements["_scheme"]) {
        url = route.requirements["_scheme"] + "://" + (host || this.getHost()) + url;
    } else if ("undefined" !== typeof route.schemes && "undefined" !== typeof route.schemes[0] && this.getScheme() !== route.schemes[0]) {
        url = route.schemes[0] + "://" + (host || this.getHost()) + url;
    } else if (host && this.getHost() !== host) {
        url = this.getScheme() + "://" + host + url;
    } else if (absolute === true) {
        url = this.getScheme() + "://" + this.getHost() + url;
    }

    if (Object.keys(unusedParams).length > 0) {
        let prefix;
        let queryParams = [];
        let add = (key, value) => {
            // if value is a function then call it and assign it's return value as value
            value = (typeof value === 'function') ? value() : value;

            // change null to empty string
            value = (value === null) ? '' : value;

            queryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
        };

        for (prefix in unusedParams) {
            this.buildQueryParams(prefix, unusedParams[prefix], add);
        }

        url = url + '?' + queryParams.join('&').replace(/%20/g, '+');
    }

    return url;
}