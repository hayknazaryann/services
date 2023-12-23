<template>
    <v-card flat>
        <v-card-title class="headline">Profile Info</v-card-title>
        <v-divider></v-divider>
        <v-card-text>
            <v-row v-if="user">
                <v-col cols="12" md="12">
                    <p class="text-h5">
                        {{user.first_name + ' ' + user.last_name}}
                    </p>
                </v-col>
                <v-col cols="12" md="12" v-if="user.specialization">
                    <p class="text-subtitle-1">
                        {{user.specialization}}
                    </p>
                </v-col>
                <v-col cols="12" md="12" v-if="user.about">
                    <p class="text-body-2 font-weight-light">
                        {{user.about}}
                    </p>
                </v-col>
                <v-col cols="12" md="12">
                    <v-chip-group>
                        <v-chip
                            prepend-icon="mdi-phone"
                            v-if="user.phone"
                            :href="`tel:${user.phone}`"
                        >
                            {{user.phone}}
                        </v-chip>
                        <v-chip
                            prepend-icon="mdi-email"
                            :href="`mailto:${user.email}`"
                        >
                            {{user.email}}
                        </v-chip>
                    </v-chip-group>

                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>
<script>
export default {
    props: ['user'],
};
</script>
<style scoped>

</style>
