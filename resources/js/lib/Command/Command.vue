<template>
    <div class="mr-4 w-full flex-1 md:w-auto md:flex-none" @click="isOpenDialog = true">
        <button
            class="focus-visible:outline-hidden relative flex h-10 w-full items-center justify-start rounded-md border border-input bg-background px-4 py-2 text-sm font-medium text-muted-foreground ring-offset-background transition-colors focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 sm:pr-12 md:w-40 lg:w-64"
        >
            <span class="hidden text-gray-400 lg:inline-flex">検索...</span>
            <span class="inline-flex text-gray-400 lg:hidden">検索...</span>
            <kbd
                class="pointer-events-none absolute right-[9px] top-[9px] hidden h-5 select-none items-center gap-1 rounded-sm border bg-muted px-1.5 font-mono text-[10px] font-medium opacity-100 sm:flex"
            >
                <span class="text-xs">⌘</span>K
            </kbd>
        </button>
    </div>

    <!-- <Self :visible="isOpenDialog" @dialog="handleOpenDialog" @select="handleChangeDialog" /> -->
    <!-- <component :is="currentDialog" v-if="isOpenThemeDialog" /> -->
</template>

<script lang="ts" setup>
import { useMagicKeys } from '@vueuse/core';
import { ref, watch } from 'vue';

const isOpenDialog = ref(false);
const isOpenThemeDialog = ref(false);
// const selectedView = ref('');
// const target = ref(null)
// const currentDialog = computed(() => {
//     if (selectedView.value === 'Linear') return Linear;
//     if (selectedView.value === 'Vercel') return Vercel;
//     if (selectedView.value === 'Raycast') return Raycast;
// });

const keys = useMagicKeys();
const CmdK = keys['Meta+K'];
const Escape = keys['Escape'];

// const handleChangeDialog = (view = 'self') => {
//     const isSelf = view === 'self';
//     selectedView.value = view;
//     isOpenDialog.value = isSelf;
//     isOpenThemeDialog.value = !isSelf;
// };
// const handleOpenDialog = (value) => {
//     if (value) {
//         isOpenDialog.value = true;
//     } else {
//         isOpenDialog.value = false;
//     }
// };

watch(CmdK, (v) => {
    if (v) {
        console.log('Meta + K has been pressed');
        isOpenDialog.value = true;
    }
});
watch(Escape, (v) => {
    if (v) {
        console.log('Escape has been pressed');
        isOpenDialog.value = false;
        isOpenThemeDialog.value = false;
    }
});
// onClickOutside(target, (event) => {
//   console.log('Clicked the outside element of Command K Palette')
//   isOpenDialog.value = false
// })
</script>

<style>
@import './assets/css/global.css';
</style>
