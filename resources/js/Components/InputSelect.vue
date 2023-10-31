<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        required: false,
    },
});

defineEmits(['update:modelValue']);

const select = ref(null);
</script>

<template>
    <select
        :value="modelValue"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="select"
    >
        <option v-for="option in options" :value="option.value">{{ option.text }}</option>
    </select>
</template>

<style scoped>

</style>
