<script setup>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import { useData } from '@/composables/data.js'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from '@inertiajs/vue3';
import { ArrowUpIcon, ArrowDownIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    auth: Object,
    can: Object,
})

const {
    fetchedData,
    nextPageDisabled,
    prevPageDisabled,
    fetchNext,
    fetchPrev,
    total,
    deleteData,
    updateDirection,
    getDirection
} = useData({
        url: route('api.products.index'),
        token: props.auth.token,
        perPage: 5,
        relations: ['category']
    }
)

</script>

<template>
    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 ">

                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Products List</h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                List of all products
                            </p>
                        </div>

                        <div v-if="can.manage_products">
                            <ButtonLink :href="route('products.create')"> Add Product </ButtonLink>
                        </div>
                    </div>

                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">
                                                <a href="#" @click="updateDirection('name')" class="group inline-flex items-center justify-between gap-1">
                                                    <ArrowDownIcon class="h-4 w-4" v-if="getDirection('name') === 'desc'" />
                                                    <ArrowUpIcon class="h-4 w-4" v-else />

                                                    Name
                                                </a>
                                            </th>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">
                                                <a href="#" @click="updateDirection('slug')" class="group inline-flex items-center justify-between gap-1">
                                                    <ArrowDownIcon class="h-4 w-4" v-if="getDirection('slug') === 'desc'" />
                                                    <ArrowUpIcon class="h-4 w-4" v-else />

                                                    Slug
                                                </a>
                                            </th>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">
                                                <a href="#" @click="updateDirection('price')" class="group inline-flex items-center justify-between gap-1">
                                                    <ArrowDownIcon class="h-4 w-4" v-if="getDirection('price') === 'desc'" />
                                                    <ArrowUpIcon class="h-4 w-4" v-else />

                                                    Price
                                                </a>
                                            </th>

                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">Category</th>

                                            <th v-if="can.manage_products" scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                        <tr v-for="(product, index) in fetchedData" :key="index">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">
                                                {{ product.name }}
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">
                                                {{ product.slug }}
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">
                                                {{ product.price }}
                                            </td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">
                                                {{ product.category.name }}
                                            </td>


                                            <td v-if="can.manage_products" class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <Link :href="route('products.edit', product)" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-2">
                                                    Edit
                                                </Link>

                                                <a href="#" @click="deleteData(route('api.products.destroy', product))" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-between items-center sm:px-6 lg:px-8">
                                <div class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">
                                    Showing {{ fetchedData.length }} of {{ total }} results
                                </div>
                                <div class="flex justify-end gap-3">
                                    <PrimaryButton :disabled="prevPageDisabled" @click="fetchPrev">Previous</PrimaryButton>
                                    <PrimaryButton :disabled="nextPageDisabled" @click="fetchNext">Next</PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
