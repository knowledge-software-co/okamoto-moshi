<script setup lang="ts">
import { TransitionRoot } from '@headlessui/vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { ref } from 'vue';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: trans('Profile settings'),
        href: '/settings/profile',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    _method: 'PUT',
    name: user.name,
    email: user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);
const currentProfilePhotoUrl = ref(user.profile_photo_url);

const submit = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: (response) => {
            if (response?.props?.auth?.user) {
                const updatedUser = response.props.auth.user;
                if (updatedUser.profile_photo_path) {
                    user.profile_photo_path = updatedUser.profile_photo_path;
                }
                if (updatedUser.profile_photo_url) {
                    currentProfilePhotoUrl.value = updatedUser.profile_photo_url;
                }
            }
            clearPhotoFileInput();
        },
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            currentProfilePhotoUrl.value = null;
            user.profile_photo_path = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="$t('Profile settings')" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall :title="$t('Profile information')" :description="$t('Update your name and email address')" />

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Profile Photo -->
                    <div class="col-span-6 sm:col-span-4">
                        <!-- Profile Photo File Input -->
                        <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />

                        <Label for="photo">{{ $t('Photo') }}</Label>

                        <!-- Current Profile Photo -->
                        <div v-show="!photoPreview" class="mt-2">
                            <img
                                v-if="currentProfilePhotoUrl"
                                :src="currentProfilePhotoUrl"
                                :alt="user.name"
                                class="h-20 w-20 rounded-full object-cover"
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
                                class="h-20 w-20 rounded-full object-cover"
                            />
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div v-show="photoPreview" class="mt-2">
                            <span
                                class="block h-20 w-20 rounded-full bg-cover bg-center bg-no-repeat"
                                :style="'background-image: url(\'' + photoPreview + '\');'"
                            />
                        </div>

                        <Button class="mr-2 mt-2" type="button" @click.prevent="selectNewPhoto">
                            {{ $t('Select A New Photo') }}
                        </Button>

                        <Button v-if="user.profile_photo_path" type="button" class="mt-2" @click.prevent="deletePhoto">
                            {{ $t('Remove Photo') }}
                        </Button>

                        <InputError :message="form.errors.photo" class="mt-2" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">{{ $t('Name') }}</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" :placeholder="$t('Full name')" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">{{ $t('Email address') }}</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            :placeholder="$t('Email address')"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            {{ $t('Your email address is unverified.') }}
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:!decoration-current dark:decoration-neutral-500"
                            >
                                {{ $t('Click here to resend the verification email.') }}
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            {{ $t('A new verification link has been sent to your email address.') }}
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">{{ $t('Save') }}</Button>

                        <TransitionRoot
                            :show="form.recentlySuccessful"
                            enter="transition ease-in-out"
                            enter-from="opacity-0"
                            leave="transition ease-in-out"
                            leave-to="opacity-0"
                        >
                            <p class="text-sm text-neutral-600">{{ $t('Saved.') }}</p>
                        </TransitionRoot>
                    </div>
                </form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>
