<template>
  <Command.Item @select="onSelect">
    <slot />
    <div command-vercel-shortcuts="">
      <kbd v-for="(key, index) in shortcut" :key="index">{{ key }}</kbd>
    </div>
  </Command.Item>
</template>

<script lang="ts" setup>
import { Command } from 'vue-command-palette'
import type { ItemInfo } from 'vue-command-palette'

defineProps({
  shortcut: {
    type: Array
  }
})

const emit = defineEmits<(e: 'select', item: ItemInfo) => void>()

const onSelect = (item: ItemInfo) => emit('select', item)
</script>
