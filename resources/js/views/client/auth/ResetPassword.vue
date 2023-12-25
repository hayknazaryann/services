<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="7"
            >
                <v-card class="p-3 rounded-shaped elevation-8 gradient-bg">
                    <v-card-title class="text-center text-uppercase">
                        Reset Password
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form @submit.prevent="resetPassword" ref="passwordForm">
                            <v-row justify="center" class="pa-md-5">
                                <v-col cols="12" md="8">
                                    <v-text-field
                                        label="New Password"
                                        type="password"
                                        v-model="data.password"
                                        :rules="rules.password"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="8">
                                    <v-text-field
                                        label="Confirm New Password"
                                        type="password"
                                        v-model="data.password_confirmation"
                                        :rules="rules.password_confirmation"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="8" class="text-center">
                                    <v-btn
                                        type="submit"
                                        color="primary"
                                        variant="outlined"
                                        :loading="loading"
                                    >Reset</v-btn>
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
    props: ['token', 'email'],
    data() {
        return {
            loading: false,
            data: {
                password: '',
                password_confirmation: '',
                token: this.token,
                email: this.email
            },
            rules: {
                password: [
                    v => !!v || 'New Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
                password_confirmation: [
                    v => !!v || 'Confirm Password is required',
                    v => (this.data.password === v) || 'Password must match'
                ],
            }
        };
    },
    methods: {
        ...mapActions({
            'appResetPassword': 'profile/resetPassword'
        }),
        async resetPassword() {
            const {valid} = await this.$refs.passwordForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.appResetPassword(this.data).then((response) => {
                        this.loading = false;
                    });
                } catch (e) {
                    if (e.status === 422) {
                        this.errors = e.data.errors;
                    }
                    this.loading = false;
                }
            }
        },
    },
};
</script>
<style scoped>

</style>
