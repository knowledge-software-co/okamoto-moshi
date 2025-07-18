<script setup>
// import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
// import route from 'ziggy-js';

import { notify } from 'notiwind';
import convertByte from '@/functions/convertByte.ts';

// import JetButton from '@/Jetstream/Button.vue';
// import JetFormSection from '@/Jetstream/FormSection.vue';
// import JetInput from '@/Jetstream/Input.vue';
// import JetTextarea from '@/Jetstream/Textarea.vue';
// import JetCheckbox from '@/Jetstream/Checkbox.vue';
// import JetInputError from '@/Jetstream/InputError.vue';
// import JetLabel from '@/Jetstream/Label.vue';
// import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
// import JetSectionBorderForm from '@/Jetstream/SectionBorderForm.vue';

// import JetBarContainer from '@/Components/JetBar/JetBarContainer.vue';
// import JetBarAlert from '@/Components/JetBar/JetBarAlert.vue';
// import JetBarStatsContainer from '@/Components/JetBar/JetBarStatsContainer.vue';
// import JetBarStatCard from '@/Components/JetBar/JetBarStatCard.vue';
// import JetBarTable from '@/Components/JetBar/JetBarTable.vue';
// import JetBarTableData from '@/Components/JetBar/JetBarTableData.vue';
// import JetBarBadge from '@/Components/JetBar/JetBarBadge.vue';
// import JetBarIcon from '@/Components/JetBar/JetBarIcon.vue';

const props = defineProps({
    contentType: {
        type: String,
        default: 'image',
        validator: (value) => {
            return [
                'image',
                'movie',
                'voice',
                'pdf',
                'card type message',
                'single button',
                'multiple buttons',
                'ticket',
            ].includes(value);
        },
    },
    maxSize: {
        type: Number,
        default: 10 * 1024 * 1024, // 10MB
    },
    instruction: {
        type: String,
        default: (props) => {
            switch (props.contentType) {
                case 'image':
                    return 'PNG or JPG (MAX. ' + convertByte(props.maxSize) + ')';
                case 'pdf':
                    return 'PDF (MAX. ' + convertByte(props.maxSize) + ')';
                default:
                    return '';
            }
        },
    },
});

const formFile = defineModel({
    type: Object,
    default: null,
});

const imagePreview = ref(null);
const imageInput = ref(null);
const dropzoneDrag = ref(false);

const selectNewImage = () => {
    imageInput.value.click();
};

const imageClick = () => {
    dropzoneDrag.value = false;
    updateFilePreview(imageInput.value.files[0]);
};

const imageOnDrop = (event) => {
    dropzoneDrag.value = false;
    updateFilePreview(event.dataTransfer.files[0]);
};

const updateFilePreview = (inputFile) => {
    if (!inputFile) return;

    validateFile(inputFile)
        .then(() => {
            const reader = new FileReader();

            reader.onload = (e) => {
                imagePreview.value = e.target.result;
            };

            reader.readAsDataURL(inputFile);

            formFile.value = inputFile;
        })
        .catch((error) => {
            notify(
                {
                    group: 'error',
                    title: 'Error',
                    text: error,
                },
                5000,
            );
            clearFileInput();
        });
};

const validateFile = (inputFile) => {
    if (!inputFile) return true;

    return new Promise((resolve, reject) => {
        const fileType = inputFile.type;
        const isImage = props.contentType === 'image';
        const isPdf = props.contentType === 'pdf';

        if (isImage && fileType !== 'image/jpeg' && fileType !== 'image/png') {
            reject('画像のフォーマットが不正です。');
            return;
        }

        if (isPdf && fileType !== 'application/pdf') {
            reject('PDFのフォーマットが不正です。');
            return;
        }

        if (inputFile.size > props.maxSize) {
            reject('ファイルサイズが' + convertByte(props.maxSize) + 'を超えています。');
            return;
        }

        resolve(true);
    });
};

const clearFileInput = () => {
    if (imageInput.value?.value) {
        imageInput.value.value = null;
    }
    imagePreview.value = null;
    formFile.value = null;
};
</script>

<template>
    <div>
        <input ref="imageInput" type="file" class="hidden" @change="imageClick" />

        <div v-if="contentType === 'image' && imagePreview" class="mt-2">
            <img :src="imagePreview" />
        </div>
        <div v-if="contentType === 'pdf' && imagePreview" class="mt-2">
            <embed :src="imagePreview" type="application/pdf" width="100%" height="500px" />
        </div>

        <div v-if="!imagePreview" class="flex items-center justify-center w-full">
            <label
                for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                :class="{ 'border-blue-500 dark:border-blue-500': dropzoneDrag }"
                @click.prevent="selectNewImage"
                @dragover.prevent="dropzoneDrag = true"
                @dragleave.prevent="dropzoneDrag = false"
                @dragend.prevent="dropzoneDrag = false"
                @drop.prevent="imageOnDrop"
            >
                <div class="flex flex-col items-center justify-center pt-5 pb-6 pointer-events-none">
                    <svg
                        class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 16"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                        />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <template v-if="!dropzoneDrag">
                            <span class="font-semibold">クリックしてアップロード</span>
                            もしくはドラッグ・アンド・ドロップしてください。
                        </template>
                        <template v-else> ドラッグ中 </template>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ instruction }}
                    </p>
                </div>
            </label>
        </div>

        <JetSecondaryButton v-if="imagePreview" type="button" class="mt-2" @click.prevent="clearFileInput">
            リセット
        </JetSecondaryButton>
    </div>
</template>
