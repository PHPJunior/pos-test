<script setup>

import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import CategoryForm from "@/Pages/Category/Partials/CategoryForm.vue";

const props = defineProps({
    auth: Object,
    can: Object,
})

</script>

<template>
    <Head title="Add Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Add Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 ">

                    <CategoryForm :token="auth.token" class="max-w-xl" />

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
