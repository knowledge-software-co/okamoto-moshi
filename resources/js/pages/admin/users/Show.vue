<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import {
    BuildingIcon,
    CalendarIcon,
    DownloadIcon,
    FileTextIcon,
    HomeIcon,
    MailIcon,
    MessageSquareIcon,
    PencilIcon,
    PhoneIcon,
} from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: '管理者ダッシュボード',
        href: '/admin',
    },
    {
        title: 'ユーザー管理',
        href: '/admin/users',
    },
    {
        title: 'ユーザー詳細',
        href: '/admin/users/' + props.user.uuid,
    },
];

// サンプルデータ - 実際の実装では API からデータを取得する
const sampleUser = ref({
    id: 1,
    name: '山田 太郎',
    profileImage: '/placeholder.svg?height=128&width=128',
    email: 'taro.yamada@example.com',
    phone: '090-1234-5678',
    address: '東京都渋谷区渋谷1-1-1',
    birthday: '1990年5月15日',
    gender: '男性',
    introduction:
        'フロントエンドエンジニアとして5年間の経験があります。Vue.js、React、TypeScriptを使用した開発を得意としています。\n\nユーザー体験を向上させるUIの設計と実装に情熱を持っており、パフォーマンスの最適化にも力を入れています。チームでの協業を大切にし、常に新しい技術を学ぶことを心がけています。',
    department: '開発部',
    position: 'シニアフロントエンドエンジニア',
    permissions: ['プロジェクト管理', 'コード審査', 'デプロイ権限'],
    unitPrice: '8,000',
    salary: '450,000',
    yearsOfExperience: 5,
    skills: ['Vue.js', 'React', 'TypeScript', 'JavaScript', 'HTML', 'CSS', 'Tailwind CSS', 'Git', 'Jest', 'Webpack', 'Node.js'],
    experiences: [
        {
            company: '株式会社テックイノベーション',
            position: 'シニアフロントエンドエンジニア',
            period: '2021年4月 - 現在',
            description:
                '大規模Webアプリケーションのフロントエンド開発を担当。Vue.jsとTypeScriptを使用したSPAの設計と実装、パフォーマンス最適化を行う。',
        },
        {
            company: '株式会社デジタルソリューション',
            position: 'フロントエンドエンジニア',
            period: '2019年1月 - 2021年3月',
            description: 'ECサイトのフロントエンド開発。Reactを使用したコンポーネント設計、状態管理の実装を担当。',
        },
        {
            company: '株式会社ウェブクリエイト',
            position: 'Webデベロッパー',
            period: '2018年4月 - 2018年12月',
            description: 'コーポレートサイトの制作。HTML、CSS、JavaScriptを使用したレスポンシブデザインの実装。',
        },
    ],
    projects: [
        {
            name: '次世代CRMシステム開発',
            status: '進行中',
            role: 'フロントエンドリード',
            description: '顧客管理システムのUI/UX設計と実装を担当。Vue.js、TypeScript、GraphQLを使用。',
        },
        {
            name: 'ECサイトリニューアル',
            status: '計画中',
            role: 'フロントエンドエンジニア',
            description: '既存ECサイトのパフォーマンス改善とモバイル対応の強化。',
        },
        {
            name: '社内ダッシュボード開発',
            status: '完了',
            role: 'フルスタックエンジニア',
            description: '社内データ可視化ツールの開発。Vue.jsとNode.jsを使用。',
        },
    ],
    resumeLastUpdated: '2023年10月15日',
});
</script>
<template>
    <Head title="得意先管理" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-background p-4 md:p-6">
            <div class="mx-auto max-w-5xl">
                <div class="overflow-hidden rounded-lg border border-border bg-card shadow-sm">
                    <!-- Header with profile image and basic info -->
                    <div class="relative h-32 bg-muted">
                        <div class="absolute -bottom-12 left-6">
                            <div class="relative h-24 w-24 rounded-full border-4 border-background bg-background">
                                <img
                                    v-if="currentProfilePhotoUrl"
                                    :src="currentProfilePhotoUrl"
                                    :alt="user.name"
                                    class="h-full w-full rounded-full object-cover"
                                />
                                <img
                                    v-else
                                    :src="
                                        'https://ui-avatars.com/api/?name=' +
                                        user.name
                                            .split(' ')
                                            .map((segment) => segment.trim().charAt(0))
                                            .join(' ')
                                            .trim() +
                                        '&color=7F9CF5&background=EBF4FF'
                                    "
                                    :alt="user.name"
                                    class="h-full w-full rounded-full object-cover"
                                />
                                <button class="absolute bottom-0 right-0 rounded-full bg-primary p-1 text-primary-foreground shadow-sm">
                                    <PencilIcon class="h-3 w-3" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-16">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h1 class="text-xl font-semibold text-foreground">{{ user.name }}</h1>
                                <p class="text-sm text-muted-foreground">{{ sampleUser.position }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    class="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                                    <MessageSquareIcon class="mr-2 h-4 w-4" />
                                    メッセージ
                                </button>
                                <button
                                    class="inline-flex h-9 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium text-foreground ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                                    <FileTextIcon class="mr-2 h-4 w-4" />
                                    編集
                                </button>
                            </div>
                        </div>

                        <!-- Main content -->
                        <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                            <!-- Left column - Personal information -->
                            <div class="space-y-6 md:col-span-1">
                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <h2 class="mb-4 text-sm font-medium text-foreground">個人情報</h2>

                                    <div class="space-y-3">
                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">メールアドレス</p>
                                            <p class="flex items-center text-sm text-foreground">
                                                <MailIcon class="mr-2 h-3.5 w-3.5 text-muted-foreground" />
                                                {{ sampleUser.email }}
                                            </p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">電話番号</p>
                                            <p class="flex items-center text-sm text-foreground">
                                                <PhoneIcon class="mr-2 h-3.5 w-3.5 text-muted-foreground" />
                                                {{ sampleUser.phone }}
                                            </p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">住所</p>
                                            <p class="flex items-center text-sm text-foreground">
                                                <HomeIcon class="mr-2 h-3.5 w-3.5 text-muted-foreground" />
                                                {{ sampleUser.address }}
                                            </p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">誕生日</p>
                                            <p class="flex items-center text-sm text-foreground">
                                                <CalendarIcon class="mr-2 h-3.5 w-3.5 text-muted-foreground" />
                                                {{ sampleUser.birthday }}
                                            </p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">性別</p>
                                            <p class="text-sm text-foreground">{{ sampleUser.gender }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <h2 class="mb-4 text-sm font-medium text-foreground">組織情報</h2>

                                    <div class="space-y-3">
                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">所属部署</p>
                                            <p class="flex items-center text-sm text-foreground">
                                                <BuildingIcon class="mr-2 h-3.5 w-3.5 text-muted-foreground" />
                                                {{ sampleUser.department }}
                                            </p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">役職</p>
                                            <p class="text-sm text-foreground">{{ sampleUser.position }}</p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">権限</p>
                                            <div class="mt-1 flex flex-wrap gap-1.5">
                                                <span
                                                    v-for="(permission, index) in sampleUser.permissions"
                                                    :key="index"
                                                    class="inline-flex items-center rounded-md bg-muted px-2 py-1 text-xs font-medium text-foreground"
                                                >
                                                    {{ permission }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <h2 class="mb-4 text-sm font-medium text-foreground">財務情報</h2>

                                    <div class="space-y-3">
                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">単価</p>
                                            <p class="text-sm font-medium text-foreground">{{ sampleUser.unitPrice }}円 / 時間</p>
                                        </div>

                                        <div class="group">
                                            <p class="text-xs text-muted-foreground">給与</p>
                                            <p class="text-sm font-medium text-foreground">{{ user.salary }}円 / 月</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right column - Professional information -->
                            <div class="space-y-6 md:col-span-2">
                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <h2 class="mb-4 text-sm font-medium text-foreground">自己紹介</h2>
                                    <p class="whitespace-pre-line text-sm text-foreground">
                                        {{ sampleUser.introduction }}
                                    </p>
                                </div>

                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <h2 class="mb-4 text-sm font-medium text-foreground">スキル</h2>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span
                                            v-for="(skill, index) in sampleUser.skills"
                                            :key="index"
                                            class="inline-flex items-center rounded-md bg-primary/10 px-2.5 py-0.5 text-xs font-medium text-primary"
                                        >
                                            {{ skill }}
                                        </span>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <div class="mb-4 flex items-center justify-between">
                                        <h2 class="text-sm font-medium text-foreground">エンジニア歴</h2>
                                        <p class="text-xs text-muted-foreground">{{ sampleUser.yearsOfExperience }}年</p>
                                    </div>

                                    <div class="relative">
                                        <div class="absolute bottom-0 left-3 top-0 w-px bg-border"></div>
                                        <div v-for="(experience, index) in sampleUser.experiences" :key="index" class="relative mb-5 pl-8 last:mb-0">
                                            <div class="absolute left-3 top-1 h-2 w-2 -translate-x-1/2 transform rounded-full bg-primary"></div>
                                            <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                                                <div>
                                                    <h3 class="text-sm font-medium text-foreground">
                                                        {{ experience.company }}
                                                    </h3>
                                                    <p class="text-xs text-muted-foreground">
                                                        {{ experience.position }}
                                                    </p>
                                                </div>
                                                <p class="text-xs text-muted-foreground">
                                                    {{ experience.period }}
                                                </p>
                                            </div>
                                            <p class="mt-1.5 text-xs text-foreground">
                                                {{ experience.description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <h2 class="mb-4 text-sm font-medium text-foreground">参画中プロジェクト</h2>
                                    <div class="space-y-3">
                                        <div
                                            v-for="(project, index) in sampleUser.projects"
                                            :key="index"
                                            class="rounded-md border border-border bg-card-foreground/[.01] p-3"
                                        >
                                            <div class="flex justify-between">
                                                <h3 class="text-sm font-medium text-foreground">
                                                    {{ project.name }}
                                                </h3>
                                                <span
                                                    :class="{
                                                        'bg-success/10 text-success': project.status === '進行中',
                                                        'bg-warning/10 text-warning': project.status === '計画中',
                                                        'bg-info/10 text-info': project.status === '完了',
                                                    }"
                                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium"
                                                >
                                                    {{ project.status }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-xs text-muted-foreground">
                                                {{ project.role }}
                                            </p>
                                            <p class="mt-1.5 text-xs text-foreground">
                                                {{ project.description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-border bg-card p-4 shadow-sm">
                                    <div class="mb-4 flex items-center justify-between">
                                        <h2 class="text-sm font-medium text-foreground">職務経歴書</h2>
                                        <button class="inline-flex items-center text-xs font-medium text-primary hover:underline">
                                            <DownloadIcon class="mr-1 h-3.5 w-3.5" />
                                            ダウンロード
                                        </button>
                                    </div>
                                    <div class="rounded-md border border-border bg-card-foreground/[.01] p-3">
                                        <p class="text-xs text-muted-foreground">最終更新: {{ sampleUser.resumeLastUpdated }}</p>
                                        <div class="mt-2 flex h-32 items-center justify-center rounded-md border border-dashed border-border">
                                            <div class="text-center">
                                                <FileTextIcon class="mx-auto h-8 w-8 text-muted-foreground" />
                                                <p class="mt-1 text-xs text-muted-foreground">職務経歴書.pdf</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
:root {
    --background: 0 0% 100%;
    --foreground: 240 10% 3.9%;
    --card: 0 0% 100%;
    --card-foreground: 240 10% 3.9%;
    --popover: 0 0% 100%;
    --popover-foreground: 240 10% 3.9%;
    --primary: 240 5.9% 10%;
    --primary-foreground: 0 0% 98%;
    --secondary: 240 4.8% 95.9%;
    --secondary-foreground: 240 5.9% 10%;
    --muted: 240 4.8% 95.9%;
    --muted-foreground: 240 3.8% 46.1%;
    --accent: 240 4.8% 95.9%;
    --accent-foreground: 240 5.9% 10%;
    --destructive: 0 84.2% 60.2%;
    --destructive-foreground: 0 0% 98%;
    --border: 240 5.9% 90%;
    --input: 240 5.9% 90%;
    --ring: 240 5.9% 10%;
    --radius: 0.5rem;
    --success: 142.1 76.2% 36.3%;
    --warning: 38 92% 50%;
    --info: 221.2 83.2% 53.3%;
}

.dark {
    --background: 240 10% 3.9%;
    --foreground: 0 0% 98%;
    --card: 240 10% 3.9%;
    --card-foreground: 0 0% 98%;
    --popover: 240 10% 3.9%;
    --popover-foreground: 0 0% 98%;
    --primary: 0 0% 98%;
    --primary-foreground: 240 5.9% 10%;
    --secondary: 240 3.7% 15.9%;
    --secondary-foreground: 0 0% 98%;
    --muted: 240 3.7% 15.9%;
    --muted-foreground: 240 5% 64.9%;
    --accent: 240 3.7% 15.9%;
    --accent-foreground: 0 0% 98%;
    --destructive: 0 62.8% 30.6%;
    --destructive-foreground: 0 0% 98%;
    --border: 240 3.7% 15.9%;
    --input: 240 3.7% 15.9%;
    --ring: 240 4.9% 83.9%;
    --success: 142.1 70.6% 45.3%;
    --warning: 48 96.5% 58.8%;
    --info: 217.2 91.2% 59.8%;
}

.bg-background {
    background-color: hsl(var(--background));
}
.bg-foreground {
    color: hsl(var(--foreground));
}
.bg-card {
    background-color: hsl(var(--card));
}
.bg-card-foreground {
    color: hsl(var(--card-foreground));
}
.bg-popover {
    background-color: hsl(var(--popover));
}
.bg-popover-foreground {
    color: hsl(var(--popover-foreground));
}
.bg-primary {
    background-color: hsl(var(--primary));
}
.bg-primary-foreground {
    color: hsl(var(--primary-foreground));
}
.bg-secondary {
    background-color: hsl(var(--secondary));
}
.bg-secondary-foreground {
    color: hsl(var(--secondary-foreground));
}
.bg-muted {
    background-color: hsl(var(--muted));
}
.bg-muted-foreground {
    color: hsl(var(--muted-foreground));
}
.bg-accent {
    background-color: hsl(var(--accent));
}
.bg-accent-foreground {
    color: hsl(var(--accent-foreground));
}
.bg-destructive {
    background-color: hsl(var(--destructive));
}
.bg-destructive-foreground {
    color: hsl(var(--destructive-foreground));
}
.bg-border {
    background-color: hsl(var(--border));
}
.bg-input {
    background-color: hsl(var(--input));
}
.bg-ring {
    background-color: hsl(var(--ring));
}
.bg-primary\/10 {
    background-color: hsl(var(--primary) / 0.1);
}
.bg-success\/10 {
    background-color: hsl(var(--success) / 0.1);
}
.bg-warning\/10 {
    background-color: hsl(var(--warning) / 0.1);
}
.bg-info\/10 {
    background-color: hsl(var(--info) / 0.1);
}

.text-foreground {
    color: hsl(var(--foreground));
}
.text-primary {
    color: hsl(var(--primary));
}
.text-primary-foreground {
    color: hsl(var(--primary-foreground));
}
.text-muted-foreground {
    color: hsl(var(--muted-foreground));
}
.text-accent-foreground {
    color: hsl(var(--accent-foreground));
}
.text-success {
    color: hsl(var(--success));
}
.text-warning {
    color: hsl(var(--warning));
}
.text-info {
    color: hsl(var(--info));
}

.border-border {
    border-color: hsl(var(--border));
}
.border-input {
    border-color: hsl(var(--input));
}

.ring-offset-background {
    --tw-ring-offset-color: hsl(var(--background));
}

.focus-visible\:ring-ring:focus-visible {
    --tw-ring-color: hsl(var(--ring));
}
</style>
