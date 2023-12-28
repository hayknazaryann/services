<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="7"
            >
                <v-card class="p-3 rounded-shaped elevation-8 gradient-bg">
                    <v-card-title class="text-center text-uppercase">
                        Verify Email
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="text-center">
                        <p v-if="message">{{ message }}</p>
                        <v-btn
                            variant="outlined"
                            color="primary"
                            :loading="loading"
                            @click="!error ? verify() : resend()"
                        >
                            {{!error ? 'Verify' : 'Resend'}}
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import {mapActions} from "vuex";
const queryString = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')
export default {
    name: 'VerifyEmail',
    props: ['id', 'hash'],
    data() {
        return {
            loading: false,
            message: '',
            error: ''
        }
    },
    created() {

    },
    methods:{
        ...mapActions({
            appVerify: 'profile/verifyEmail',
            appVerifyResend: 'profile/resendVerifyEmail',
        }),
        async verify(){
            await this.appVerify({id: this.id, hash: this.hash})
                .then((response) => {
                    this.loading = false;
                }).catch((error) => {
                    this.loading = false;
                });
        },
        async resend() {
            this.loading = true;
            await this.appVerifyResend().then((response) => {
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
            });
        },
    },
}
</script>
