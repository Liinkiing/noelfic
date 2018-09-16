import AuthManager from "./managers/AuthManager"
import { setContext } from "apollo-link-context";
import { onError } from "apollo-link-error";

let token;
const withToken = setContext(() => {
    if (token) return { token };

    return AuthManager.askNewToken().then(userToken => {
        if(userToken) {
            token = userToken;
            AuthManager.login(token)
            return { token };
        } else {
            AuthManager.logout()
        }
    });
});

const resetToken = onError(({ networkError }) => {
    if (networkError && networkError.statusCode === 401) {
        token = null;
    }
});

export default withToken.concat(resetToken);