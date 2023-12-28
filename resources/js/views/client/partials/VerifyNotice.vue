<template>
    <v-container tag="section">
        <v-row justify="center" class="align-items-center">
            <v-col
                cols="12"
                md="9"
            >
                <v-banner
                    lines="one"
                    icon="$warning"
                    color="warning"
                    class="my-4 pa-md-5 rounded-shaped elevation-8 gradient-bg"
                >
                    <v-banner-text class="text-warning">
                        {{ message }}
                    </v-banner-text>

                    <template v-slot:actions>
                        <v-btn
                            variant="outlined"
                            color="warning"
                            :loading="loading"
                            @click="resend"
                        >
                            Resend
                        </v-btn>
                    </template>
                </v-banner>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import {mapActions} from "vuex";
export default {
    name: 'VerifyNotice',
    props: ['id'],
    data() {
        return {
            loading: false,
            message: 'Your email address is not verified. please check your mail inbox!',
        }
    },
    methods:{
        ...mapActions({
            appVerifyResend: 'profile/resendVerifyEmail',
        }),
        async resend() {
            this.loading = true;
            await this.appVerifyResend({id: this.id}).then((response) => {
                this.loading = false;
            });
        },
    }
}
</script>
