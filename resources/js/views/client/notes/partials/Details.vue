<template>
    <v-card
        class="text-center text-h5 mt-3 mb-4"
        :title="item.title"
    >
        <v-card-text class="mt-3 mb-4" v-html="item.text">
        </v-card-text>
    </v-card>
</template>
<script>
export default {
    name: 'Details',
    props: ['item']
}
</script>
<style scoped>

</style>
