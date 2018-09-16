import {AUTH_TOKEN} from "../vue-apollo"
import jwtDecode from "jwt-decode"

class AuthManager {
    isTokenValid() {
        try {
            const decoded = jwtDecode(this.getToken())
            const expirationDate = new Date(decoded.exp * 1000)
            return expirationDate > Date.now()
        } catch (e) {
            this.removeToken()
            return false
        }
    }

    hasToken() {
        return (
            localStorage.getItem(AUTH_TOKEN) !== "undefined" &&
            localStorage.getItem(AUTH_TOKEN) !== undefined &&
            localStorage.getItem(AUTH_TOKEN) !== null
        )
    }

    removeToken() {
        localStorage.removeItem(AUTH_TOKEN)
    }

    setToken(token) {
        localStorage.setItem(AUTH_TOKEN, token)
    }

    getToken() {
        return localStorage.getItem(AUTH_TOKEN)
    }

    async askNewToken() {
        if (this.isLoggedIn()) {
            let request = await fetch(process.env.VUE_APP_GET_TOKEN_URL, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/json',
                    "Content-Type": "application/json",
                }
            })
            if (request.ok) {
                return await request.json()
            }

            return null
        }

        return null
    }

    isLoggedIn() {
        return this.hasToken()
    }
}

const instance = new AuthManager()
export default instance