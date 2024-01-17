<template>
    <v-app id="inspire" :class="isDark ? 'theme-dark' : 'theme-light'">
        <v-parallax
            :src="isDark ? bgImageDark : bgImageWhite"
        >
            <v-app-bar app :elevation="4">
                <v-toolbar-title>Application</v-toolbar-title>
                <template v-slot:append>
                    <v-btn v-if="!isAuthenticated"
                           :to="{ name: 'login' }"
                           icon="mdi-login-variant"
                           title="Login"
                    ></v-btn>
                    <v-btn v-if="!isAuthenticated"
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

            <v-bottom-navigation :elevation="14" v-if="isAuthenticated">
                <v-btn :to="{ name: 'profile' }">
                    <v-icon>mdi-account</v-icon>
                    <span>Profile</span>
                </v-btn>

                <v-btn :to="{ name: 'notes.index'}">
                    <v-icon>mdi-note</v-icon>
                    <span>My Notes</span>
                </v-btn>

                <v-btn @click="logout">
                    <v-icon>mdi-logout</v-icon>
                    <span>Logout</span>
                </v-btn>
            </v-bottom-navigation>
        </v-parallax>
    </v-app>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import bgImageDark from '@images/bg/dark.webp';
import bgImageWhite from '@images/bg/white.webp';
import VerifyNotice from "@client/partials/VerifyNotice.vue";
export default {
    name: "App",
    components: {
        VerifyNotice
    },
    data: () => ({
        bgImageDark,
        bgImageWhite
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
        background: linear-gradient(#0000007F, #0000007F) !important;
    }

    .card-bg {
        background: #1b1b1b !important;
    }
}

.theme-light {
    .gradient-bg {
        background: linear-gradient(#FFFFFFFF, #FFFFFFFF) !important;
    }

    .card-bg {
        background: #eaeaea !important;
    }
}


.min-100vh {
    min-height: 100vh;;
}

.min-90vh {
    min-height: 90vh;;
}
.m-auto {
    margin: auto !important;
}
</style>
