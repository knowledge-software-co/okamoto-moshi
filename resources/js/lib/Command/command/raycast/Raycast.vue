<template>
    <Command.Dialog :visible="visible" theme="raycast" @select-item="handleSelectItem">
        <template #header>
            <div command-raycast-top-shine="" />
            <Command.Input placeholder="Search for apps and commands..." />
            <hr command-raycast-loader="" />
        </template>
        <template #body>
            <!-- <Command.Loading> Hang on... </Command.Loading> -->
            <Command.List ref="dialogRef">
                <Command.Empty>No results found.</Command.Empty>
                <Home />
            </Command.List>
        </template>
        <template #footer>
            <RaycastDarkIcon v-if="isDark" />
            <RaycastLightIcon v-else />
            <button command-raycast-open-trigger="">
                Open Application
                <kbd>↵</kbd>
            </button>

            <hr />
            <button command-raycast-subcommand-trigger="">
                Actions
                <kbd>⌘</kbd>
                <kbd>K</kbd>
            </button>
        </template>
    </Command.Dialog>
</template>

<script lang="ts" setup>
// import { ref, watch } from 'vue';
import { useMagicKeys, useToggle } from '@vueuse/core';
import { watch } from 'vue';
import { isDark } from '../../composables/useDarkmode.ts';

import { ItemInfo } from '@/types';
import { Command } from 'vue-command-palette';
import RaycastDarkIcon from '../../icons/RaycastDarkIcon.vue';
import RaycastLightIcon from '../../icons/RaycastLightIcon.vue';
import Home from './Home.vue';

const handleSelectItem = (item: ItemInfo) => {
    console.log(item);
};

const [visible, visibleToggle] = useToggle();

const keys = useMagicKeys();
const CmdK = keys['Meta+K'];

watch(CmdK, (v) => {
    if (v) {
        console.log('Meta + K has been pressed');
        // do your own logic, maybe make dialog visible
        visibleToggle();
    }
});
</script>

<style>
@import '../../assets/css/raycast.css';
</style>
