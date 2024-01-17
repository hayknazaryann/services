<template>
    <v-col cols="12" md="4" class="text-end">
        <v-text-field
            label="Search"
            v-model="keyword"
            prepend-inner-icon="mdi-magnify"
            variant="solo"
        ></v-text-field>
    </v-col>
    <v-col cols="12" md="8" class="text-end">
        <v-btn
            color="default"
            variant="outlined"
            icon="mdi-note-plus"
            @click="openForm"
        ></v-btn>
    </v-col>
    <v-col
        v-for="note in notes"
        class="column"
        cols="12"
        md="3"
        sm="6"
    >
        <v-card class="p-3 rounded-shaped w-100 d-flex flex-column" variant="elevated" elevation="12">
            <v-card-title>
                {{note.title}}
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                {{note.shortText + '...'}}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="view(note)"
                       icon="mdi-note-text"
                ></v-btn>
                <v-btn @click="openForm(note)"
                       icon="mdi-note-edit"
                ></v-btn>
                <v-btn @click="deleteNote(note)"
                       icon="mdi-note-remove"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
    <v-col cols="12" md="12">
        <paginate @loading="setLoader"></paginate>
    </v-col>
    <v-dialog
        transition="dialog-bottom-transition"
        v-model="detailsDialog"
        @click:outside="closeDetails"
        width="800"
        scrollable
    >
        <notes-details :item="item" @close="closeDetails"></notes-details>
    </v-dialog>
    <v-dialog v-model="formDialog" @click:outside="close">
        <note-form :item="item" @close="close"></note-form>
    </v-dialog>
    <v-dialog v-model="deleteDialog" @click:outside="closeDelete">
        <note-delete :item="item" @close="closeDelete"></note-delete>
    </v-dialog>
    <v-dialog
        v-model="loading"
        :scrim="false"
        persistent
        width="auto"
    >
        <v-card>
            <v-card-text>
                Loading...
                <v-progress-linear
                    indeterminate
                    color="white"
                    class="mb-0"
                ></v-progress-linear>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
import Paginate from "@client/notes/partials/Paginate.vue";
import NotesDetails from '@client/notes/partials/Details.vue';
import NoteForm from '@client/notes/partials/Form.vue';
import NoteDelete from '@client/notes/partials/DeleteDialog.vue';
import NoteFilters from '@client/notes/partials/Filters.vue';
import {mapGetters} from "vuex";
import  debounce from "debounce";
export default {
    components: {
        Paginate, NotesDetails, NoteForm, NoteDelete, NoteFilters
    },
    data() {
        return {
            detailsDialog: false,
            formDialog: false,
            deleteDialog: false,
            loading: false,
            keyword: '',
            pageSize: 12,
            item: {
                title: '',
                text: null,
            },
            defaultItem: {
                title: '',
                text: null,
            },
        };
    },
    watch: {
        detailsDialog (val) {
            val || this.closeDetails()
        },
        formDialog (val) {
            val || this.close()
        },
        deleteDialog (val) {
            val || this.closeDelete()
        },
    },
    computed: {
        ...mapGetters({
            notes: 'notes/getNotes'
        })
    },
    mounted() {
        this.getNotes();
    },
    methods: {
        view (item) {
            this.item = Object.assign({}, item)
            this.detailsDialog = true
        },
        openForm (item = {}) {
            this.item = Object.assign({}, item)
            this.formDialog = true
        },
        deleteNote (item) {
            this.item = Object.assign({}, item)
            this.deleteDialog = true
        },
        closeDetails () {
            this.detailsDialog = false
            this.$nextTick(() => {
                this.item = Object.assign({}, this.defaultItem)
            })
        },
        close () {
            this.formDialog = false
            this.$nextTick(() => {
                this.item = Object.assign({}, this.defaultItem)
            })
        },
        closeDelete () {
            this.deleteDialog = false
            this.$nextTick(() => {
                this.item = Object.assign({}, this.defaultItem)
            })
        },
        setLoader(loading) {
            this.loading = loading;
        },

        async getNotes() {
            await this.$store.dispatch('notes/getNotes', {
                keyword: this.keyword,
                pageSize: this.pageSize
            })
        },

        search: debounce(async function () {
            await this.$store.dispatch('notes/getNotes', {
                keyword: this.keyword,
                pageSize: this.pageSize
            })
        }, 600),

        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        }
    },


};
</script>
<style scoped>
.column {
    display: flex;
    align-self: stretch;
}
</style>
