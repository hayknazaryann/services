<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="6"
            >
                <v-card class="p-3 rounded-lg" :elevation="7">
                    <v-card-title>Login</v-card-title>
                    <v-card-text>
                        <v-form
                            class="d-flex flex-column ga-3"
                            ref="loginForm"
                            lazy-validation
                        >

                            <v-text-field
                                v-model="auth.email"
                                :rules="rules.email"
                                label="E-mail"
                            ></v-text-field>

                            <v-text-field
                                v-model="auth.password"
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

export default {
    name:'login',
    data(){
        return {
            auth:{
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
        async login(){
            console.log(this.$refs);
            const {valid} = await this.$refs.loginForm.validate()
            if (valid) {

            }
        },
    }
}
</script>


<style scoped>

</style>
