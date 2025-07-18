import { shallowMount } from '@vue/test-utils';
import { describe, it, expect } from 'vitest';
import Welcome from '@/pages/Welcome.vue';
import { Head } from '@inertiajs/vue3';

// Inertiaのページコンテキストをモック
const mockInertia = {
    page: {
        component: 'Welcome',
        props: {
            auth: { user: null },
            // アプリケーションで必要な他のpropsをここに追加
        },
        url: '',
        version: ''
    }
};

describe('Welcome.vue', () => {
    it('can render the welcome page', () => {
        const wrapper = shallowMount(Welcome, {
            global: {
                mocks: {
                    $page: mockInertia.page,
                    // Ziggyのルートヘルパーが使われていれば追加
                    route: (name, params) => `route(${name}, ${params})`
                },
                stubs: {
                    Head: true // Headコンポーネントをスタブ化
                }
            }
        });

        const head = wrapper.findComponent(Head);
        expect(head.exists()).toBe(true);
    });
});
