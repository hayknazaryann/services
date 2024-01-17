<template>
    <v-container class="container-lg" tag="section">
        <v-row justify="start"  class="min-100vh w-100 m-auto">
            <notes-list></notes-list>
        </v-row>
    </v-container>
</template>
<script>
import NotesList from '@client/notes/partials/List.vue';
export default {
    components: {
        NotesList
    },
    name: 'Index',
    data() {
        return {

        };
    },
};
</script>
<style scoped>

</style>
