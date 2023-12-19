<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="6"
            >
                <v-card class="p-4 rounded-lg" :elevation="7">
                    <v-card-title>Register</v-card-title>
                    <v-card-text>
                        <v-form
                            class="d-flex flex-column ga-2"
                            ref="registerForm"
                            @submit.prevent
                        >
                            <v-text-field
                                v-model="auth.firstName"
                                label="First Name"
                                :rules="rules.firstName"
                                required
                            ></v-text-field>
                            <v-text-field
                                v-model="auth.lastName"
                                label="Last Name"
                                :rules="rules.lastName"
                            ></v-text-field>
                            <v-text-field
                                v-model="auth.email"
                                label="E-mail"
                                :rules="rules.email"
                            ></v-text-field>

                            <v-text-field
                                v-model="auth.password"
                                type="password"
                                label="Password"
                                :rules="rules.password"
                            ></v-text-field>
                            <v-text-field
                                v-model="auth.confirmPassword"
                                type="password"
                                label="Password confirm"
                                :rules="rules.confirmPassword"
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
export default {
    name:'register',
    data(){
        return {
            auth:{
                firstName:'',
                lastName:'',
                email:'',
                password:'',
                confirmPassword:'',
            },
            errors: null,
            rules: {
                firstName: [
                    v => !!v || 'First Name is required',
                    v => (v && v.length >= 2) || 'First Name must be more than 2 characters',
                ],
                lastName: [
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
                confirmPassword: [
                    v => !!v || 'Confirm Password is required',
                    v => (this.auth.password === v) || 'Password must match'
                ],
            }
        }
    },
    methods:{
        async register(){
            const {valid} = await this.$refs.registerForm.validate()
            if (valid) {

            }
        },
    }
}
</script>
<style scoped>

</style>
