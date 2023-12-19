<template>
    <v-layout>
        <v-theme-provider theme="customDarkTheme">
            <v-app id="inspire">
                <v-app-bar :elevation="7" title="Application" fixed>
                    <template v-slot:append>
                        <v-btn :to="`/`" icon="mdi-home" title="Home"></v-btn>
                        <v-btn :to="`/login`" icon="mdi-login-variant" title="Login"></v-btn>
                        <v-btn :to="`/register`" icon="mdi-account-plus" title="Register"></v-btn>
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
            'isDark': 'settings/darkMode'
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
            changeTheme: 'settings/changeTheme'
        }),
        switchTheme() {
            this.changeTheme();
            this.$vuetify.theme.name = this.theme
        },
    }
}
</script>

<style scoped>

</style>
