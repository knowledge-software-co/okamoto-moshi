<template>
    <div class="relative">
        <input
            class="shadow-xs block h-full w-full rounded-md border pl-9 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border dark:border-input dark:bg-background dark:text-gray-300 dark:placeholder-gray-500"
            :placeholder="label"
            :value="value"
            type="text"
            name="global"
            @input="onChange($event.target.value)"
        />
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                />
            </svg>
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        default: 'Search...',
        required: false,
    },

    value: {
        type: String,
        default: '',
        required: false,
    },

    onChange: {
        type: Function,
        required: true,
    },
});
</script>
