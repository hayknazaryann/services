<template>
    <v-form @submit.prevent="updateProfile" ref="profileForm">
        <v-row class="pa-md-4">
            <v-col cols="12" md="12">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            label="First Name"
                            v-model="user.first_name"
                            :rules="rules.first_name"
                            :error-messages="errors && errors.first_name ? errors.first_name[0] : ''"
                            clearable
                            outlined
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            label="Last Name"
                            v-model="user.last_name"
                            :rules="rules.last_name"
                            :error-messages="errors && errors.last_name ? errors.last_name[0] : ''"
                            clearable
                            outlined
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            label="Specialization"
                            v-model="user.specialization"
                            :error-messages="errors && errors.specialization ? errors.specialization[0] : ''"
                            clearable
                            outlined
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-row>
                            <v-col cols="12" md="12">
                                <v-phone-input
                                    v-model="user.phone"
                                ></v-phone-input>
                            </v-col>

                        </v-row>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            label="Address"
                            v-model="user.address"
                            :error-messages="errors && errors.address ? errors.address[0] : ''"
                            clearable
                            outlined
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="12">
                        <v-textarea
                            label="About"
                            v-model="user.about"
                            :error-messages="errors && errors.about ? errors.about[0] : ''"
                            outlined
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" md="12" class="text-center">
                        <v-btn
                            type="submit"
                            color="primary"
                            variant="outlined"
                            :loading="loading"
                        >Update</v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row>

        </v-row>
    </v-form>

</template>
<script>
import {mapActions} from "vuex";
import {VPhoneInput} from "v-phone-input";
export default {
    components: {VPhoneInput},
    props: ['user'],
    data() {
        return {
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
            }
        };
    },
    methods: {
        ...mapActions({
            profileUpdate: 'profile/updateProfile'
        }),
        async updateProfile() {
            const {valid} = await this.$refs.profileForm.validate()
            if (valid) {
                this.loading = true;
                this.errors = null;
                try {
                    await this.profileUpdate(this.user).then((response) => {
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
    },
};
</script>
<style scoped>

</style>
