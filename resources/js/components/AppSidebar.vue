<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, User, Building } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { trans } from 'laravel-vue-i18n';

const mainNavItems: NavItem[] = (() => {
    if (['system admin', 'admin'].includes(usePage().props.auth.user.role)) {
        return [
            {
                title: '管理者ダッシュボード',
                href: '/admin',
                icon: LayoutGrid,
            },
            {
                title: 'ユーザー管理',
                href: '/admin/users',
                icon: User,
            },
            {
                title: '社員管理',
                href: '/admin/employees',
                icon: User,
            },
            {
                title: '技術者管理',
                href: '/admin/engineers',
                icon: User,
            },
            {
                title: '得意先管理',
                href: '/admin/customers',
                icon: Building,
            },
        ];
    } else {
        return [
            {
                title: trans('Dashboard'),
                href: '/dashboard',
                icon: LayoutGrid,
            },
        ];
    }
})();

const footerNavItems: NavItem[] = [
    {
        title: trans('Github Repo'),
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: trans('Documentation'),
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <template v-if="$page.props.auth.user.role_name == 'SystemAdmin' || $page.props.auth.user.role_name == 'Admin'">
                            <Link :href="route('admin.dashboard')">
                                <AppLogo />
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('dashboard')">
                                <AppLogo />
                            </Link>
                        </template>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
