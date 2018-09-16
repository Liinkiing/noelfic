import Vue from "vue"
import VueApollo from "vue-apollo"
import {createApolloClient, restartWebsockets} from "vue-cli-plugin-apollo/graphql-client"
// import AuthManager from "./managers/AuthManager"


// Install the vue plugin
Vue.use(VueApollo)

// Name of the localStorage item
export const AUTH_TOKEN = "jwt"

// Config
const defaultOptions = {
    // You can use `https` for secure connection (recommended in production)
    httpEndpoint:
        process.env.VUE_APP_GRAPHQL_HTTP || "http://localhost:4000/graphql",
    // You can use `wss` for secure connection (recommended in production)
    // Use `null` to disable subscriptions
    wsEndpoint: null,
    // LocalStorage token
    tokenName: AUTH_TOKEN,
    // Enable Automatic Query persisting with Apollo Engine
    persisting: false,
    // Use websockets for everything (no HTTP)
    // You need to pass a `wsEndpoint` for this to work
    websocketsOnly: false,
    // Is being rendered on the server?
    ssr: false,

    // Override default http link
    // link: httpLink

    // Override default cache
    // cache: myCache

    // Override the way the Authorization header is set
    // getAuth: (tokenName) => ...

    // Additional ApolloClient options
    // apollo: { ... }

    // Client local data (see apollo-link-state)
    // clientState: { resolvers: { ... }, defaults: { ... } }
}

// Call this in the Vue app file
export function createProvider(options = {}) {
    // Create apollo client
    const { apolloClient, wsClient } = createApolloClient({
        ...defaultOptions,
        ...options
    })
    apolloClient.wsClient = wsClient

    // Create vue apollo provider
    return new VueApollo({
        defaultClient: apolloClient,
        defaultOptions: {
            $query: {
                fetchPolicy: "cache-and-network"
            }
        },
        errorHandler(error) {
            // eslint-disable-next-line no-console
            console.log(
                "%cError",
                "background: red color: white padding: 2px 4px border-radius: 3px font-weight: bold",
                error.message
            )
        }
    })
}

// Manually call this when user log in
export function onLogin(apolloClient, token, refreshToken, referrer) {
    if (apolloClient.wsClient) restartWebsockets(apolloClient.wsClient)
    try {
        // AuthManager.setToken(token)
        if(referrer) {
            window.location.replace(referrer.fullPath)
        } else {
            window.location.reload(true)
        }
    } catch (e) {
        // eslint-disable-next-line no-console
        console.log("%cError on cache reset (login)", "color: orange", e.message)
    }
}

// Manually call this when user log out
export function onLogout(apolloClient, referrer) {
    if (apolloClient.wsClient) restartWebsockets(apolloClient.wsClient)
    try {
        // AuthManager.removeToken()
        if(referrer) {
            window.location.replace(referrer.fullPath)
        } else {
            window.location.reload(true)
        }
    } catch (e) {
        // eslint-disable-next-line no-console
        console.log("%cError on cache reset (logout)", "color: orange", e.message)
    }
}