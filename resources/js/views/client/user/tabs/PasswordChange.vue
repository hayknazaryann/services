<template>
    <v-form @submit.prevent="changePassword" ref="passwordForm">
        <v-row justify="center" class="pa-md-5">
            <v-col cols="12" md="8">
                <v-text-field
                    label="Current Password"
                    type="password"
                    v-model="password.current"
                    :rules="rules.password"
                    required
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="8">
                <v-text-field
                    label="New Password"
                    type="password"
                    v-model="password.new"
                    :rules="rules.new"
                    required
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="8">
                <v-text-field
                    label="Confirm New Password"
                    type="password"
                    v-model="password.confirm"
                    :rules="rules.confirm"
                    required
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="8" class="text-center">
                <v-btn
                    type="submit"
                    color="primary"
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
            password: {
                current: '',
                new: '',
                confirm: '',
            },
            rules: {
                password: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
                new: [
                    v => !!v || 'New Password is required',
                    v => (v && v.length >= 8) || 'Password must be at least 8 characters',
                ],
                confirm: [
                    v => !!v || 'Confirm Password is required',
                    v => (this.password.new === v) || 'Password must match'
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
                    await this.appPasswordChange(this.password).then((response) => {
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
