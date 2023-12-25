<template>
    <v-form @submit.prevent="changePassword" ref="passwordForm">
        <v-row justify="center" class="pa-md-5">
            <v-col cols="12" md="8">
                <v-text-field
                    label="Current Password"
                    type="password"
                    v-model="data.password"
                    :rules="rules.password"
                    required
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="8">
                <v-text-field
                    label="New Password"
                    type="password"
                    v-model="data.new_password"
                    :rules="rules.new_password"
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
                >Change</v-btn>
            </v-col>
        </v-row>
    </v-form>

</template>
<script>
import {mapActions} from "vuex";

export default {
    props: ['user'],
    data() {
        return {
            loading: false,
            data: {
                password: '',
                new_password: '',
                password_confirmation: '',
            },
            rules: {
                password: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
                new_password: [
                    v => !!v || 'New Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
                password_confirmation: [
                    v => !!v || 'Confirm Password is required',
                    v => (this.password.new_password === v) || 'Password must match'
                ],
            }
        };
    },
    methods: {
        ...mapActions({
           'appPasswordChange': 'profile/changePassword'
        }),
        async changePassword() {
            const {valid} = await this.$refs.passwordForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.appPasswordChange(this.data).then((response) => {
                        this.loading = false;
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
    },
};
</script>
<style scoped>

</style>
