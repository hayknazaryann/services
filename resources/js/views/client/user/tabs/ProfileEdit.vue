<template>
    <v-card flat>
        <v-card-title class="headline">Edit Profile</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
            <v-form @submit.prevent="updateProfile" ref="profileForm">
                <v-row>
                    <v-col cols="12" md="7">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="First Name"
                                    v-model="user.first_name"
                                    :rules="rules.first_name"
                                    :error-messages="errors && errors.first_name ? errors.first_name[0] : ''"
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Last Name"
                                    v-model="user.last_name"
                                    :rules="rules.last_name"
                                    :error-messages="errors && errors.last_name ? errors.last_name[0] : ''"
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <v-select
                                            label="Code"
                                            v-model="user.phone_code"
                                            :items="countryCodes"
                                            :error-messages="errors && errors.phone_code ? errors.phone_code[0] : ''"
                                            clearable
                                            outlined
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="8">
                                        <v-text-field
                                            label="Phone"
                                            v-model="user.phone_number"
                                            :error-messages="errors && errors.phone_number ? errors.phone_number[0] : ''"
                                            clearable
                                            outlined
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Address"
                                    v-model="user.address"
                                    :error-messages="errors && errors.address ? errors.address[0] : ''"
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Specialization"
                                    v-model="user.specialization"
                                    :error-messages="errors && errors.specialization ? errors.specialization[0] : ''"
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols12>
                                <v-textarea
                                    label="About"
                                    v-model="user.about"
                                    :error-messages="errors && errors.about ? errors.about[0] : ''"
                                    outlined
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12" md="5">
                        <v-date-picker
                            title="Birth Date"
                            v-model="user.birthdate"
                            :error-messages="errors && errors.birthdate ? errors.birthdate[0] : ''"
                            elevation="4"
                            show-adjacent-months
                        ></v-date-picker>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="12">
                        <v-btn
                            type="submit"
                            color="primary"
                            :loading="loading"
                        >Update</v-btn>
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
            loading: false,
            errors: null,
            countryCodes: ['+374', '+7'],
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
                        console.log(response);
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
