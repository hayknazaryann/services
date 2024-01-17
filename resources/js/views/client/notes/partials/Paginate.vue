<template>
    <v-card class="rounded-lg" v-if="lastPage > 1">
        <v-card-text>
            <v-pagination
                v-model="currentPage"
                :length="lastPage"
                :total-visible="7"
                rounded="circle"
            ></v-pagination>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "Paginate",
    watch: {
        currentPage (newVal, oldVal) {
            this.paginatePage(newVal);
        }
    },
    computed: {
        currentPage: {
            get() {
                return this.$store.state.notes.currentPage;
            },
            set(value) {
                this.$store.commit('notes/SET_CURRENT_PAGE', value);
            }
        },
        lastPage: {
            get() {
                return this.$store.state.notes.lastPage;
            }
        }
    },
    methods: {
        async paginatePage(page) {
            await this.$store.dispatch('notes/getNotes', { page: page })
        }
    }
}
</script>

<style scoped>

</style>
