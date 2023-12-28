<template>
    <v-layout :class="isDark ? 'theme-dark' : 'theme-light'">
        <v-app id="inspire">
            <v-app-bar :elevation="4" title="Application" class="gradient-bg" fixed>
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
            <v-parallax
                :src="isDark ? bgImageDark : bgImageWhite"
            >

                <v-main class="d-flex flex-column align-center justify-center min-100vh">
                    <verify-notice
                        v-if="
                        $route.name !== 'home' &&
                        $route.name !== 'verify.email' &&
                        isAuthenticated &&
                        user &&
                        !user.verified
                        "
                        :id="user.id"
                    ></verify-notice>

                    <router-view></router-view>
                </v-main>
            </v-parallax>

            <v-footer
                :elevation="7"
                class="text-center d-flex flex-column gradient-bg"
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
    </v-layout>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import bgImageDark from '../../../../img/bg/dark.webp';
import bgImageWhite from '../../../../img/bg/white.webp';
import VerifyNotice from "../partials/VerifyNotice.vue";

export default {
    name: "App",
    components: {
        VerifyNotice
    },
    data: () => ({
        bgImageDark,
        bgImageWhite,
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
            'isAuthenticated': 'profile/isAuthenticated',
            'user': 'profile/user'
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
                await this.appLogout(this.user)
                    .then((response) => {});
            } catch (e) {

            }
        },
    }
}
</script>

<style lang="scss">
.theme-dark {
    .gradient-bg {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)) !important;
    }
}

.theme-light {
    .gradient-bg {
        background: linear-gradient(rgb(255, 255, 255), rgb(255, 255, 255)) !important;
    }
}


.min-100vh {
    min-height: 100vh;;
}

.min-90vh {
    min-height: 90vh;;
}
</style>
