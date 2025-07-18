<template>
    <div v-if="hasPagination" class="flex items-center justify-between border-t border-border px-2 py-2">
        <p v-if="!hasData || pagination.total < 1" class="text-sm text-muted-foreground">
            {{ translations.no_results_found }}
        </p>

        <!-- simple and mobile -->
        <div v-if="hasData" class="flex flex-1 justify-between" :class="{ 'sm:hidden': hasLinks }">
            <button
                :disabled="!previousPageUrl"
                :dusk="previousPageUrl ? 'pagination-simple-previous' : null"
                class="relative inline-flex items-center gap-1 rounded-md bg-background px-2.5 py-1.5 text-sm font-medium text-muted-foreground hover:text-foreground disabled:pointer-events-none disabled:opacity-50"
                @click.prevent="onClick(previousPageUrl)"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span>{{ translations.previous }}</span>
            </button>

            <div class="flex items-center space-x-4">
                <PerPageSelector dusk="per-page-mobile" :value="perPage" :options="perPageOptions" :on-change="onPerPageChange" />
            </div>

            <button
                :disabled="!nextPageUrl"
                :dusk="nextPageUrl ? 'pagination-simple-next' : null"
                class="relative inline-flex items-center gap-1 rounded-md bg-background px-2.5 py-1.5 text-sm font-medium text-muted-foreground hover:text-foreground disabled:pointer-events-none disabled:opacity-50"
                @click.prevent="onClick(nextPageUrl)"
            >
                <span>{{ translations.next }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
        </div>

        <!-- full pagination -->
        <div v-if="hasData && hasLinks" class="hidden w-full sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center space-x-6">
                <PerPageSelector dusk="per-page-full" :value="perPage" :options="perPageOptions" :on-change="onPerPageChange" />

                <p class="text-sm text-muted-foreground">
                    <span>{{ pagination.from }}</span>
                    {{ translations.to }}
                    <span>{{ pagination.to }}</span>
                    {{ translations.of }}
                    <span>{{ pagination.total }}</span>
                    {{ translations.results }}
                </p>
            </div>

            <div class="flex">
                <nav class="flex space-x-1" aria-label="Pagination">
                    <button
                        :disabled="!previousPageUrl"
                        :dusk="previousPageUrl ? 'pagination-previous' : null"
                        class="relative rounded-sm p-1.5 text-muted-foreground hover:text-foreground disabled:pointer-events-none disabled:opacity-50"
                        @click.prevent="onClick(previousPageUrl)"
                    >
                        <span class="sr-only">{{ translations.previous }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>

                    <div v-for="(link, key) in pagination.links" :key="key">
                        <slot name="link">
                            <button
                                v-if="!isNaN(link.label) || link.label === '...'"
                                :disabled="!link.url"
                                :dusk="link.url ? `pagination-${link.label}` : null"
                                class="relative inline-flex h-9 min-w-9 items-center justify-center rounded-sm px-1.5 text-sm font-medium text-muted-foreground disabled:pointer-events-none disabled:opacity-50"
                                :class="{
                                    'hover:text-foreground': link.url && !link.active,
                                    'bg-muted text-foreground': link.active,
                                }"
                                @click.prevent="onClick(link.url)"
                            >
                                {{ link.label }}
                            </button>
                        </slot>
                    </div>

                    <button
                        :disabled="!nextPageUrl"
                        :dusk="nextPageUrl ? 'pagination-next' : null"
                        class="relative rounded-sm p-1.5 text-muted-foreground hover:text-foreground disabled:pointer-events-none disabled:opacity-50"
                        @click.prevent="onClick(nextPageUrl)"
                    >
                        <span class="sr-only">{{ translations.next }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import PerPageSelector from './PerPageSelector.vue';
import { getTranslations } from './translations.js';

const translations = getTranslations();

const props = defineProps({
    onClick: {
        type: Function,
        required: false,
    },
    perPageOptions: {
        type: Array,
        default: () => [15, 30, 50, 100],
        required: false,
    },
    onPerPageChange: {
        type: Function,
        default() {
            return () => {};
        },
        required: false,
    },
    hasData: {
        type: Boolean,
        required: true,
    },
    meta: {
        type: Object,
        required: false,
    },
});

const hasLinks = computed(() => {
    if (!('links' in pagination.value)) {
        return false;
    }

    return pagination.value.links.length > 0;
});

const hasPagination = computed(() => {
    return Object.keys(pagination.value).length > 0;
});

const pagination = computed(() => {
    return props.meta;
});

const previousPageUrl = computed(() => {
    if ('prev_page_url' in pagination.value) {
        return pagination.value.prev_page_url;
    }

    return null;
});

const nextPageUrl = computed(() => {
    if ('next_page_url' in pagination.value) {
        return pagination.value.next_page_url;
    }

    return null;
});

const perPage = computed(() => {
    return parseInt(pagination.value.per_page);
});
</script>
