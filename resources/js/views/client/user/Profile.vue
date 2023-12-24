<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="9">
                <v-card class="rounded-shaped elevation-8 min-90vh gradient-bg">
                    <v-tabs
                        v-model="tab"
                        direction="horizontal"
                        align-tabs="center"
                        color="primary"
                        centered
                        stacked
                    >
                        <v-tab value="info">
                            <v-icon start>mdi-account</v-icon>
                        </v-tab>
                        <v-tab value="profile">
                            <v-icon start>mdi-account-edit</v-icon>
                        </v-tab>
                        <v-tab value="password">
                            <v-icon start>mdi-account-lock</v-icon>
                        </v-tab>
                    </v-tabs>
                    <v-divider></v-divider>
                    <v-spacer></v-spacer>
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
