<template>
    <th v-show="!cell.hidden" class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
        <component
            :is="cell.sortable ? 'button' : 'div'"
            class="flex h-10 w-full flex-row items-center whitespace-nowrap px-2 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-[2px]"
            :dusk="cell.sortable ? `sort-${cell.key}` : null"
            @click.prevent="onClick"
        >
            <span class="flex flex-row items-center">
                <slot name="label"
                    ><span class="uppercase">{{ cell.label }}</span></slot
                >

                <slot name="sort">
                    <svg
                        v-if="cell.sortable"
                        aria-hidden="true"
                        class="ml-2 h-3 w-3"
                        :class="{
                            'text-gray-400 dark:text-gray-500': !cell.sorted,
                            'text-green-500 dark:text-green-400': cell.sorted,
                        }"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 320 512"
                        :sorted="cell.sorted"
                    >
                        <path
                            v-if="!cell.sorted"
                            fill="currentColor"
                            d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"
                        />

                        <path
                            v-if="cell.sorted === 'asc'"
                            fill="currentColor"
                            d="M279 224H41c-21.4 0-32.1-25.9-17-41L143 64c9.4-9.4 24.6-9.4 33.9 0l119 119c15.2 15.1 4.5 41-16.9 41z"
                        />

                        <path
                            v-if="cell.sorted === 'desc'"
                            fill="currentColor"
                            d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z"
                        />
                    </svg>
                </slot>
            </span>
        </component>
    </th>
</template>

<script setup>
const props = defineProps({
    cell: {
        type: Object,
        required: true,
    },
});

function onClick() {
    if (props.cell.sortable) {
        props.cell.onSort(props.cell.key);
    }
}
</script>
