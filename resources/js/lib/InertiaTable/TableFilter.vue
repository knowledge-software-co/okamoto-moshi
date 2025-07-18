<template>
  <div class="order-2 sm:order-1 mr-2 sm:mr-4">
    <ButtonWithDropdown
      placement="bottom-end"
      dusk="filters-dropdown"
      :active="hasEnabledFilters"
    >
      <template #button>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          :class="{
            'text-muted-foreground': !hasEnabledFilters,
            'text-primary': hasEnabledFilters,
          }"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
            clip-rule="evenodd"
          />
        </svg>
      </template>

      <div
        role="menu"
        aria-orientation="horizontal"
        aria-labelledby="filter-menu"
        class="min-w-[240px]"
      >
        <div
          v-for="(filter, key) in filters"
          :key="key"
          class="border-b border-border last:border-0"
        >
          <h3 class="px-3 py-2 text-xs font-medium text-foreground">
            {{ filter.label }}
          </h3>
          <div class="p-3">
            <select
              v-if="filter.type === 'select'"
              :name="filter.key"
              :value="filter.value"
              class="w-full h-9 rounded-md border border-input bg-background px-3 py-1 text-sm text-foreground ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
              @change="onFilterChange(filter.key, $event.target.value)"
            >
              <option
                v-for="(option, optionKey) in filter.options"
                :key="optionKey"
                :value="optionKey"
              >
                {{ option }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </ButtonWithDropdown>
  </div>
</template>

<script setup>
import ButtonWithDropdown from "./ButtonWithDropdown.vue";

defineProps({
    hasEnabledFilters: {
        type: Boolean,
        required: true,
    },

    filters: {
        type: Object,
        required: true,
    },

    onFilterChange: {
        type: Function,
        required: true,
    },
});
</script>

