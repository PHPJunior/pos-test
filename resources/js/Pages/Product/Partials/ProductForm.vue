<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import {useAxios} from "@/composables/axios.js";
import InputSelect from "@/Components/InputSelect.vue";

const props = defineProps({
    categories: {
        type: Array,
        required: false,
    },
    product: {
        type: Object,
        required: false,
    },
    token: {
        type: String,
        required: true,
    },
})

const { axiosInstance } = useAxios(props.token);

const form = ref({
    data: {
        name: props.product ? props.product.name : '',
        slug: props.product ? props.product.slug : '',
        category_id: props.product ? props.product.category_id : '',
        price: props.product ? props.product.price : '',
    },
    errors: {},
    processing: false,
    recentlySuccessful: false,
    submit() {
        onSubmit();
    }
});

const onSubmit = () => {

    form.value.processing = true;
    form.value.recentlySuccessful = false;

    if (props.product) {
        axiosInstance.put(route('api.products.update', props.product.id), form.value.data).then(() => {
            form.value.recentlySuccessful = true;
        }).catch((error) => {
            form.value.errors = error.response.data.errors;
        }).finally(() => {
            form.value.processing = false;
        })
    } else {
        axiosInstance.post(route('api.products.store'), form.value.data).then(() => {
            form.value.recentlySuccessful = true;
        }).catch((error) => {
            form.value.errors = error.response.data.errors;
            form.value.processing = false;
        }).finally(() => {
            form.value.processing = false;
        })
    }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Product Information</h2>
        </header>

        <form @submit.prevent="form.submit()" class="mt-6 space-y-3">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.data.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name?.join()" />
            </div>

            <div>
                <InputLabel for="slug" value="Slug" />

                <TextInput
                    id="slug"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.data.slug"
                    required
                    autofocus
                    autocomplete="slug"
                />

                <InputError class="mt-2" :message="form.errors.slug?.join()" />
            </div>

            <div>
                <InputLabel for="category" value="Category" />

                <InputSelect
                    id="category"
                    v-model="form.data.category_id"
                    class="mt-1 block w-full"
                    :options="categories.map((category) => ({ text: category.name, value: category.id }))"
                />

                <InputError class="mt-2" :message="form.errors.category_id?.join()" />
            </div>

            <div>
                <InputLabel for="price" value="Price" />

                <TextInput
                    id="price"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.data.price"
                    required
                    autofocus
                    autocomplete="price"
                />

                <InputError class="mt-2" :message="form.errors.price?.join()" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>

</style>
