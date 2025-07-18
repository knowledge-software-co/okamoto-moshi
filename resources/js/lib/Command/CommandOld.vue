<template>
    <Command.Dialog :visible="visible" theme="raycast">
        <template #header>
            <Command.Input placeholder="Type a command or search..." />
        </template>
        <template #body>
            <Command.List>
                <Command.Empty>No results found.</Command.Empty>

                <Command.Group heading="Letters">
                    <Command.Item>a</Command.Item>
                    <Command.Item>b</Command.Item>
                    <Command.Separator />
                    <Command.Item>c</Command.Item>
                </Command.Group>

                <Command.Item>Apple</Command.Item>
            </Command.List>
        </template>
    </Command.Dialog>
</template>

<script setup lang="ts">
// import { ref, watch } from 'vue';
import { useMagicKeys, useToggle } from '@vueuse/core';
import { watch } from 'vue';
import { Command } from 'vue-command-palette';

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
/* @import '~/assets/css/custom.css'; */
</style>
