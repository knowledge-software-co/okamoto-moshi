<template>
  <div>
    <Item v-for="n in 6" :key="n" :data-value="`Project ${n}`">
      {{ `Project ${n}` }}
    </Item>
  </div>
</template>

<script lang="ts" setup>
import Item from './Item.vue'
</script>
