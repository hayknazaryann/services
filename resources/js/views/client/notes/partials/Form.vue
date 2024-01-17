<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="10">
                <v-card
                    :title="formTitle"
                >
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form @submit.prevent="save" ref="noteForm">
                            <v-row justify="center" class="pa-md-5">
                                <v-col cols="12" md="8">
                                    <v-text-field
                                        label="Title"
                                        v-model="item.title"
                                        :error-messages="errors && errors.title ? errors.title[0] : ''"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="8">
                                    <v-textarea
                                        label="About"
                                        v-model="item.text"
                                        :error-messages="errors && errors.text ? errors.text[0] : ''"
                                        required
                                    ></v-textarea>
                                </v-col>
                                <v-col cols="12" md="8" class="text-center d-flex ga-2 justify-center">
                                    <v-btn
                                        type="submit"
                                        variant="outlined"
                                        :loading="loading"
                                    >Save</v-btn>
                                    <v-btn
                                        variant="outlined"
                                        @click="close"
                                    >Close</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import { ref, defineComponent } from 'vue';

export default  {
    name: 'Details',
    props: {
        item: Object,
    },
    data() {
        return {
            loading: false,
            errors: null
        }
    },
    computed: {
        formTitle () {
            return !this.item.id ? 'New Note' : 'Edit Note';
        },
    },
    methods: {
        close() {
            this.$emit('close')
        },

        async save () {
            const {valid} = await this.$refs.noteForm.validate();
            if (valid) {
                let url = this.item.id ? 'notes/update' : 'notes/create';
                this.loading = true;
                this.errors = null;

                try {
                    await this.$store.dispatch(url, this.item).then((response) => {
                        this.loading = false;
                        this.$emit('close');
                    });
                } catch (e) {
                    if (e.response && e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                    this.loading = false;
                }
            }

        },
    }

}
</script>
<style scoped>

</style>
