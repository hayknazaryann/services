<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="6"
            >
                <v-card class="p-3 rounded-lg" :elevation="4">
                    <v-card-title>Login</v-card-title>
                    <v-card-text>
                        <v-form
                            class="d-flex flex-column ga-3"
                            ref="loginForm"
                            lazy-validation
                        >

                            <v-text-field
                                v-model="user.email"
                                :rules="rules.email"
                                label="E-mail"
                            ></v-text-field>

                            <v-text-field
                                v-model="user.password"
                                :rules="rules.password"
                                type="password"
                                label="Password"
                            ></v-text-field>

                            <v-btn
                                color="success"
                                class="mt-2"
                                @click="login"
                            >
                                Login
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions} from "vuex";
import router from "../../../router/index.js";

export default {
    name:'login',
    data(){
        return {
            user: {
                email:'',
                password:'',
            },
            rules: {
                email: [
                    v => !!v || 'Email is required',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                ],
                password: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
            },
            errors: null
        }
    },
    methods:{
        ...mapActions({
            appLogin:'auth/login'
        }),
        async login(){
            const {valid} = await this.$refs.loginForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.appLogin(this.user).then((response) => {
                        this.$router.replace({ path: '/'});
                    });
                } catch (e) {
                    if (e.status === 422) {
                        this.errors = e.data.errors;

                    } else if (e.status === 401) {

                    }
                    this.loading = false;
                }
            }
        },

    }
}
</script>


<style scoped>

</style>
