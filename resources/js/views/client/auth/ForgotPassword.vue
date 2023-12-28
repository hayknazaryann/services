<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="7"
            >
                <v-card class="p-3 rounded-shaped elevation-8 gradient-bg">
                    <v-card-title class="text-center text-uppercase">
                        Forgot Password
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form
                            @submit.prevent="forgotPassword"
                            ref="forgotPasswordForm"
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

                                <v-col cols="12" md="12" class="text-center">
                                    <v-btn
                                        type="submit"
                                        color="default"
                                        variant="outlined"
                                        class="mt-2"
                                        :loading="loading"
                                    >
                                        Submit
                                    </v-btn>
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
    name:'ForgotPassword',
    data(){
        return {
            loading: false,
            errors: null,
            user: {
                email:'',
            },
            rules: {
                email: [
                    v => !!v || 'Email is required',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                ]
            },
        }
    },
    methods:{
        ...mapActions({
            appForgotPassword: 'profile/forgotPassword'
        }),
        async forgotPassword(){
            const {valid} = await this.$refs.forgotPasswordForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.appForgotPassword(this.user).then((response) => {
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
