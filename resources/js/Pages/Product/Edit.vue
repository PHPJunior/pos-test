<script setup>

import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import CategoryForm from "@/Pages/Category/Partials/CategoryForm.vue";
import ProductForm from "@/Pages/Product/Partials/ProductForm.vue";

const props = defineProps({
    auth: Object,
    can: Object,
    categories: Array,
    product: Object,
})

</script>

<template>
    <Head title="Edit Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 ">

                    <ProductForm :product="product" :categories="categories" :token="auth.token" class="max-w-xl" />

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
