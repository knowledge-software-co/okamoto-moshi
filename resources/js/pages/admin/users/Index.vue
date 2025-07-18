<script setup lang="ts">
// import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { Pencil, Plus } from 'lucide-vue-next';

import { Badge } from '@/components/ui/badge';

// import { Table, setTranslations } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Table } from '@/lib/InertiaTable/main.js';
// import Table from "@/lib/InertiaTable/Table.vue";
// import { setTranslations } from "@/lib/InertiaTable/translations.js";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: '管理者ダッシュボード',
        href: route('admin.dashboard'),
    },
    {
        title: 'ユーザー管理',
        href: route('admin.users.index'),
    },
];

defineProps({
    users: Object,
});

// const roleColor = (status) => {
//     switch (status) {
//         case 'SystemAdmin':
//             return 'rose';
//         case 'Admin':
//             return 'teal';
//         case 'Developer':
//             return 'pink';
//         case 'Member':
//             return 'sky';
//         // case 'GrandMaster':
//         //     return 'pink';
//         // case 'LabMaster':
//         //     return 'orange';
//         // case 'Staff':
//         //     return 'lime';
//         default:
//             return 'gray';
//     }
// };

// const statusType = (status) => {
//     switch (status) {
//         case 'Unconfirmed': // 未確認
//             return 'danger-outline';
//         case 'Approved': // 承認
//             return 'info-outline';
//         case 'Reject': // 却下
//             return 'normal-outline';
//         default:
//             return 'gray';
//     }
// };

// const roleRoutes = {
//     member: 'owners',
//     developer: 'developers',
//     admin: 'admins',
// };

const getShowRoute = (user) => {
    // const userRole = roleRoutes[user.role];
    // return userRole ? route(`admin.users.${userRole}.show`, user.uuid) : '#';
    return route(`admin.users.show`, user.uuid);
};
</script>

<template>
    <Head title="ユーザー管理" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="mb-2 mt-2 flex flex-col items-start justify-between md:flex-row md:items-center">
                <h1 class="text-3xl font-semibold">
                    ユーザー管理
                    <span class="ml-2 text-sm text-muted-foreground">ログイン可能なユーザーアカウントの管理。正社員やその他ゲストアカウント等。</span>
                </h1>
                <div class="flex items-center space-x-2">
                    <Link
                        href="admin/users/create"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0"
                    >
                        <div class="flex items-center">
                            <Plus class="text-default mr-2 h-auto w-[10px] stroke-[1.5px]" />
                            ユーザー追加
                        </div>
                    </Link>
                </div>
            </div>

            <div class="min-h-[100vh] flex-1 rounded-xl dark:border-sidebar-border md:min-h-min">
                <Table :resource="users" :inertia="$inertia" :prevent-overlapping-requests="false" :input-debounce-ms="1000" :preserve-scroll="true">
                    <template #cell(name)="{ item: user }">
                        <div class="flex items-center whitespace-nowrap font-medium text-gray-900 dark:text-white">
                            <div class="avatar-group -space-x-6">
                                <div class="avatar">
                                    <div class="w-8">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name" />
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-auto pl-3">
                                <Link
                                    :href="getShowRoute(user)"
                                    class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-white dark:hover:underline"
                                >
                                    {{ user.name }}
                                </Link>
                                <p class="truncate text-xs leading-5 text-gray-500">{{ user.email }}</p>
                            </div>
                        </div>
                    </template>
                    <template #cell(service_plan)="{ item: user }">
                        {{ user?.service_plan[0]?.name ?? '-' }}
                    </template>
                    <template #cell(sex_name)="{ item: user }">
                        <Badge variant="secondary">{{ user.sex_name }}</Badge>
                    </template>
                    <template #cell(role_label)="{ item: user }">
                        <Badge>{{ user.role_label }}</Badge>
                    </template>
                    <template #cell(操作)="{ item: user }">
                        <Link
                            :href="route('admin.users.edit', user.uuid)"
                            class="inline-flex h-9 items-center justify-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0"
                        >
                            <div class="flex items-center">
                                <Pencil class="text-default mr-2 h-auto w-[10px] stroke-[1.5px]" />
                                編集
                            </div>
                        </Link>
                    </template>

                    <!-- <template #tableGlobalSearch="slotProps">
                    <div class="relative grow">
                        <input
                            type="text"
                            placeholder="検索"
                            @keyup.enter="changeGlobalSearchValue(slotProps, $event)"
                            class="block w-full text-sm border-gray-300 rounded-md shadow-xs pl-9 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg></div>
                    </div>
                </template> -->
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
