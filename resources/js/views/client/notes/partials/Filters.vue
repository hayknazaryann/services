<template>
    <v-col
        cols="12"
        md="4"
        sm="12"
    >
        <v-card class="rounded-lg">
            <v-card-text class="d-flex ga-2">
                <v-btn
                    color="default"
                    variant="outlined"
                    prepend-icon="mdi-export"
                >Export</v-btn>

            </v-card-text>
        </v-card>
    </v-col>

</template>
<script>
export default {
    name: 'Filters',
    methods: {
        create() {
            this.$emit('create')
        },
    }
}
</script>
<style scoped>

</style>
