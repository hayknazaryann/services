<template>
    <v-layout>
        <v-theme-provider theme="customDarkTheme">
            <v-app id="inspire">
                <v-app-bar :elevation="4" title="Application" fixed>
                    <template v-slot:append>
                        <v-btn :to="{ name: 'home' }" icon="mdi-home" title="Home"></v-btn>
                        <v-btn v-if="isAuthenticated" icon="mdi-note-plus" title="Notes"></v-btn>
                        <v-btn
                            :to="{ name: (isAuthenticated ? 'profile' : 'login') }"
                            :icon="isAuthenticated ? 'mdi-account' : 'mdi-login-variant'"
                            :title="isAuthenticated ? 'Profile' : 'Login'"
                        ></v-btn>
                        <v-btn v-if="isAuthenticated"
                            @click="logout"
                            icon="mdi-logout"
                            title="Logout"
                        ></v-btn>
                        <v-btn v-else
                            :to="{ name: 'register'}"
                            icon="mdi-account-plus"
                            title="Register"
                        ></v-btn>
                        <v-btn
                            :icon="darkMode ? 'mdi-white-balance-sunny' : 'mdi-weather-night'"
                            @click="switchTheme"
                        ></v-btn>
                    </template>
                </v-app-bar>
                <v-main class="d-flex align-center justify-center" style="min-height: 100vh;">
                    <router-view></router-view>
                </v-main>
                <v-footer
                    :elevation="7"
                    class="text-center d-flex flex-column"
                >
                    <div>
                        <v-btn
                            v-for="icon in icons"
                            :key="icon"
                            class="mx-4"
                            :icon="icon"
                            variant="text"
                        ></v-btn>
                    </div>

                    <div class="pt-0">
                        <!-- Footer description-->
                    </div>

                    <v-divider></v-divider>

                    <div>
                        {{ new Date().getFullYear() }} — <strong>Application</strong>
                    </div>
                </v-footer>
            </v-app>
        </v-theme-provider>
    </v-layout>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
export default {
    name: "App",
    data: () => ({
        links: [
            'Home',
            'About Us',
            'Services',
            'Blog',
            'Contact Us',
        ],
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
    }),
    computed: {
        ...mapGetters({
            'isDark': 'settings/darkMode',
            'isAuthenticated': 'profile/isAuthenticated'
        }),
        darkMode: function () {
            return this.isDark;
        },
        theme: function () {
            return this.darkMode ? 'dark' : 'light'
        }
    },
    mounted() {
        this.$vuetify.theme.name = this.theme
    },
    methods: {
        ...mapActions({
            changeTheme: 'settings/changeTheme',
            appLogout: 'profile/logout'
        }),
        switchTheme() {
            this.changeTheme();
            this.$vuetify.theme.name = this.theme
        },
        async logout(){
            try {
                await this.appLogout(this.user).then((response) => {
                    this.$router.replace({ path: '/login'});
                });
            } catch (e) {

            }
        },
    }
}
</script>

<style scoped>

</style>
