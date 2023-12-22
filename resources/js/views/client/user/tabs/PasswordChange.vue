<template>
    <v-card flat>
        <v-card-title class="headline">Change Password</v-card-title>
        <v-card-text>
            <v-form @submit.prevent="changePassword" ref="passwordForm">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            label="Current Password"
                            type="password"
                            v-model="password.current"
                            :rules="rules.password"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="New Password"
                            type="password"
                            v-model="password.new"
                            :rules="rules.new"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="Confirm New Password"
                            type="password"
                            v-model="password.confirm"
                            :rules="rules.confirm"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn type="submit" color="primary">Change</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
    </v-card>
</template>
<script>
import {mapActions} from "vuex";

export default {
    props: ['user'],
    data() {
        return {
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
