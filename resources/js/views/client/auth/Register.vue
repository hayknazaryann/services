<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="6"
            >
                <v-card class="p-4 rounded-lg" :elevation="4">
                    <v-card-title>Register</v-card-title>
                    <v-card-text>
                        <v-form
                            class="d-flex flex-column ga-2"
                            ref="registerForm"
                            @submit.prevent
                        >
                            <v-text-field
                                v-model="user.first_name"
                                label="First Name"
                                :rules="rules.first_name"
                                required
                            ></v-text-field>
                            <v-text-field
                                v-model="user.last_name"
                                label="Last Name"
                                :rules="rules.last_name"
                                required
                            ></v-text-field>
                            <v-text-field
                                v-model="user.email"
                                label="E-mail"
                                :rules="rules.email"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.password"
                                type="password"
                                label="Password"
                                :rules="rules.password"
                            ></v-text-field>
                            <v-text-field
                                v-model="user.password_confirmation"
                                type="password"
                                label="Password confirm"
                                :rules="rules.password_confirmation"
                            ></v-text-field>

                            <v-btn
                                color="success"
                                class="mt-2"
                                @click="register"
                            >
                                Register
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
    name:'register',
    data(){
        return {
            user:{
                first_name:'',
                last_name:'',
                email:'',
                password:'',
                password_confirmation:'',
            },
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
                        this.$router.replace({ path: '/login'});
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
