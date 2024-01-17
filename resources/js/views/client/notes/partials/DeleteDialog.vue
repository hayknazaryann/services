<template>

    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card class="text-center">
                    <v-card-text class="text-h5 mt-3 mb-4">Are you sure you want to delete this note?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click="close">Cancel</v-btn>
                        <v-btn @click="confirmDelete">OK</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
export default {
    name: 'DeleteDialog',
    props: ['item'],
    methods: {
        close() {
            this.$emit('close')
        },

        async confirmDelete () {
            await this.$store.dispatch('notes/delete', this.item);
            this.close()
        },
    }
}

</script>
<style scoped>

</style>
