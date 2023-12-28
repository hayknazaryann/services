<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="7"
            >
                <v-card class="p-8 rounded-shaped elevation-8 gradient-bg">
                    <v-card-title class="text-center text-uppercase">Register</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form
                            ref="registerForm"
                            @submit.prevent="register"
                        >
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.first_name"
                                        label="First Name"
                                        :rules="rules.first_name"
                                        :error-messages="errors && errors.first_name ? errors.first_name[0] : ''"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.last_name"
                                        label="Last Name"
                                        :rules="rules.last_name"
                                        :error-messages="errors && errors.last_name ? errors.last_name[0] : ''"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.email"
                                        label="E-mail"
                                        :rules="rules.email"
                                        :error-messages="errors && errors.email ? errors.email[0] : ''"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.password"
                                        type="password"
                                        label="Password"
                                        :rules="rules.password"
                                        :error-messages="errors && errors.password ? errors.password[0] : ''"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="user.password_confirmation"
                                        type="password"
                                        label="Password confirm"
                                        :rules="rules.password_confirmation"
                                        :error-messages="errors && errors.password_confirmation ? errors.password_confirmation[0] : ''"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12" class="text-center">
                                    <v-btn
                                        type="submit"
                                        color="default"
                                        variant="outlined"
                                        class="mt-2"
                                        :loading="loading"
                                    >
                                        Register
                                    </v-btn>
                                </v-col>
                                <v-divider></v-divider>
                                <v-col cols="12" md="12" class="text-center">
                                    <v-label>
                                        Already have an account ?
                                        <v-btn
                                            :to="{path: '/login'}"
                                            variant="text"
                                            color="primary"
                                        >
                                            Login
                                        </v-btn>
                                    </v-label>
                                </v-col>
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

export default {
    name:'Register',
    data(){
        return {
            user:{
                first_name:'',
                last_name:'',
                email:'',
                password:'',
                password_confirmation:'',
            },
            loading: false,
            errors: null,
            rules: {
                first_name: [
                    v => !!v || 'First Name is required',
                    v => (v && v.length >= 2) || 'First Name must be more than 2 characters',
                ],
                last_name: [
                    v => !!v || 'Last Name is required',
                    v => (v && v.length >= 2) || 'Last Name must be more than 2 characters',
                ],
                email: [
                    v => !!v || 'Email is required',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                ],
                password: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
                password_confirmation: [
                    v => !!v || 'Confirm Password is required',
                    v => (this.user.password === v) || 'Password must match'
                ],
            }
        }
    },
    methods:{
        ...mapActions({
            appRegister: 'profile/register'
        }),
        async register(){
            const {valid} = await this.$refs.registerForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.appRegister(this.user).then((response) => {
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
