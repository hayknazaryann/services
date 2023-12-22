<template>
    <v-card flat>
        <v-card-title class="headline">Edit Profile</v-card-title>
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
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Last Name"
                                    v-model="user.last_name"
                                    :rules="rules.last_name"
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
                                            clearable
                                            outlined
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="8">
                                        <v-text-field
                                            label="Phone"
                                            v-model="user.phone_number"
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
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Specialization"
                                    v-model="user.specialization"
                                    clearable
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols12>
                                <v-textarea
                                    label="About"
                                    v-model="user.about"
                                    outlined
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12" md="5">
                        <v-date-picker
                            title="Birth Date"
                            v-model="user.birthdate"
                            elevation="4"
                            show-adjacent-months
                        ></v-date-picker>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="12">
                        <v-btn type="submit" color="primary">Update</v-btn>
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
