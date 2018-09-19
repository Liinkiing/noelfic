<template>
    <div class="login-modal" v-if="show">
        <modal modal-classes="modal-info" :show="show" @close="$emit('close')" gradient="primary">
            <Loader v-if="loading" absolute size="large" with-background/>
            <div class="text-center">
                <i class="fa fa-user-circle-o fa-3x mb-4"></i>
                <form :action="`/${locale}/login`" method="post" @submit.prevent="login">
                    <base-alert type="danger" dismissible v-if="error">{{ $t(error) }}</base-alert>
                    <input v-if="csrfToken" type="hidden" name="_csrf_token" :value="csrfToken">
                    <base-input :disabled="loading" v-model="username" alternative name="_username" :placeholder="$t('form.login.username')">

                    </base-input>
                    <base-input :disabled="loading" type="password" v-model="password" alternative name="_password" :placeholder="$t('form.login.password')">

                    </base-input>
                    <base-button :disabled="loading" native-type="submit" icon="fa fa-check">
                        {{ $t('form.login.button') }}
                    </base-button>
                </form>
            </div>
        </modal>
    </div>
    
</template>

<script>
    import { mapState } from 'vuex'
    import Modal from "vue-argon-design-system/src/components/Modal"
    import AuthManager from "../../../managers/AuthManager";
    import Loader from "../Loader";

    export default {
        name: 'LoginModal',
        components: {Loader, Modal},
        props: {
            csrfToken: {type: String},
            show: {type: Boolean, required: true, default: false}
        },
        computed: {
            ...mapState('app', ['locale'])
        },
        data() {
            return {
                username: '',
                password: '',
                loading: false,
                error: null,
            }
        },
        methods: {
            async login() {
                this.error = null
                this.loading = true
                const { username, password } = this
                const result = await AuthManager.loginForm({username, password} , this.locale)
                if (result !== true) {
                    this.loading = false
                    this.error = result.error ? result.error : null
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .login-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>