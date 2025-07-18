<template>
    <select
        name="per_page"
        :dusk="dusk"
        :value="value"
        class="h-9 w-auto rounded-md border border-input bg-background px-3 py-1 text-sm text-foreground ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
        @change="onChange($event.target.value)"
    >
        <option v-for="option in perPageOptions" :key="option" :value="option">{{ option }} {{ translations.per_page }}</option>
    </select>
</template>

<script setup>
import uniq from 'lodash-es/uniq';
import { computed } from 'vue';
import { getTranslations } from './translations.js';

const translations = getTranslations();

const props = defineProps({
    dusk: {
        type: String,
        default: null,
        required: false,
    },

    value: {
        type: Number,
        default: 15,
        required: false,
    },

    options: {
        type: Array,
        default() {
            return [15, 30, 50, 100];
        },
        required: false,
    },

    onChange: {
        type: Function,
        required: true,
    },
});

const perPageOptions = computed(() => {
    let options = [...props.options];

    options.push(parseInt(props.value));

    return uniq(options).sort((a, b) => a - b);
});
</script>
