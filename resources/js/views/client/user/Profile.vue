<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="12" style="min-height: 100vh; display: grid; grid-template-columns: 2fr 10fr; gap: 10px">
                <v-card elevation="4">
                    <v-tabs
                        v-model="tab"
                        direction="vertical"
                        color="primary"
                    >
                        <v-tab value="info">
                            <v-icon size="x-large" start>mdi-account</v-icon>
                            Info
                        </v-tab>
                        <v-tab value="profile">
                            <v-icon size="x-large" start>mdi-account-edit</v-icon>
                            Edit
                        </v-tab>
                        <v-tab value="password">
                            <v-icon size="x-large" start>mdi-account-lock</v-icon>
                            Password
                        </v-tab>
                    </v-tabs>
                </v-card>

                <v-card elevation="4">
                    <v-window v-model="tab">
                        <v-window-item value="info">
                            <profile-info :user="user"></profile-info>
                        </v-window-item>
                        <v-window-item value="profile">
                            <profile-edit :user="user"></profile-edit>
                        </v-window-item>
                        <v-window-item value="password">
                            <password-change :user="user"></password-change>
                        </v-window-item>
                    </v-window>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ProfileInfo from "./tabs/ProfileInfo.vue";
import ProfileEdit from "./tabs/ProfileEdit.vue";
import PasswordChange from "./tabs/PasswordChange.vue";
import {mapGetters} from "vuex";
export default {
    components: {
        ProfileInfo,
        ProfileEdit,
        PasswordChange
    },
    data() {
        return {
            tab: 'info',
        };
    },
    computed: {
        ...mapGetters({
            'user': 'profile/user'
        }),
    },
    mounted() {
        this.$store.dispatch('profile/setUser');
    },
};
</script>

<style scoped>

</style>
