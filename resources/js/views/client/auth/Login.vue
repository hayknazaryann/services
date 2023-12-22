<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="6"
            >
                <v-card class="p-3 rounded-lg" :elevation="4">
                    <v-card-title class="text-center">Login</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form
                            @submit.prevent="login"
                            ref="loginForm"
                            lazy-validation
                        >
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.email"
                                        :rules="rules.email"
                                        :error-messages="errors && errors.email ? errors.email[0] : ''"
                                        label="E-mail"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.password"
                                        :rules="rules.password"
                                        :error-messages="errors && errors.password ? errors.password[0] : ''"
                                        type="password"
                                        label="Password"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12" class="text-center">
                                    <v-btn
                                        type="submit"
                                        color="success"
                                        class="mt-2"
                                        :loading="loading"
                                    >
                                        Login
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" md="12"></v-col>
                            </v-row>
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
            loading: false,
            errors: null,
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
        }
    },
    methods:{
        ...mapActions({
            appLogin:'profile/login'
        }),
        async login(){
            const {valid} = await this.$refs.loginForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.appLogin(this.user).then((response) => {
                        this.loading = false;
                    });
                } catch (e) {
                    if (e.response && e.response.status === 422) {
                        this.errors = e.response.data.errors;
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
