<template>
  <Command.Dialog
    :visible="true"
    theme="vercel"
    @select-item="handleSelectItem"
  >
    <template #header>
      <div command-vercel-label>
        <label v-for="(page, index) in pageTree" :key="index" command-vercel-badge>
          {{ page }}
        </label>
      </div>
      <Command.Input
        v-model="inputValue"
        placeholder="What do you need?"
      />
    </template>
    <!-- <Command.Loading> Hang on... </Command.Loading> -->
    <template #body>
      <Command.List ref="dialogRef">
        <Command.Empty>No results found.</Command.Empty>
        <Transition name="pop-page">
          <KeepAlive>
            <component :is="currentView" :key="activePage" />
          </KeepAlive>
        </Transition>
      </Command.List>
    </template>
  </Command.Dialog>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import { useMagicKeys, whenever } from '@vueuse/core'

import { toggleDarkmode } from '../../composables/useDarkmode'
import { Command } from 'vue-command-palette'
import { ItemInfo } from '@/types'

import Home from './Home.vue'
import Projects from './Projects.vue'

const { current } = useMagicKeys()

const activePage = ref('home')
const inputValue = ref('')

const isHomePage = computed(() => activePage.value === 'home')

const currentView = computed(() => {
  return isHomePage.value ? Home : Projects
})

const pageTree = computed(() => {
  let pages = ['Home']
  if (isHomePage.value) {
    pages = ['Home']
  } else {
    pages.push(activePage.value)
  }
  return pages
})

const togglePage = () => {
  activePage.value = isHomePage.value ? 'projects' : 'home'
}

const handleKeyDown = () => {
  if (isHomePage.value || inputValue.value.length) {
    return
  }

  togglePage()
}

whenever(() => current.has('backspace'), handleKeyDown)

const handleSelectItem = (item: ItemInfo) => {
  if (item.value === 'Search Projects...') {
    togglePage()
  }
  if (item.value === 'Toggle Dark Mode') {
    toggleDarkmode()
  }
}
</script>

<style>
@import '../../assets/css/vercel.css';

.pop-page-enter-active {
  animation: scale-in 0.2s;
}
.pop-page-leave-active {
  animation: scale-in 0.2s reverse;
}

@keyframes scale-in {
  0% {
    transform: scale(0.96);
    opacity: 0;
  }

  100% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>
