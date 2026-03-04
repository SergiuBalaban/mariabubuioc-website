<script setup lang="ts">
import { useDropZone } from '@vueuse/core';
import axios from 'axios';
import { Upload, X, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    modelValue: string[] | null;
    uploadUrl: string;
    error?: string;
    label?: string;
}>();

const emit = defineEmits(['update:modelValue']);

const uploading = ref(false);
const dropZoneRef = ref<HTMLDivElement | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);

const uploadFile = async (file: File) => {
    if (!file) return;

    uploading.value = true;
    const formData = new FormData();
    formData.append('cover', file); // Folosim 'cover' pentru că așa așteaptă controller-ul

    try {
        const response = await axios.post(props.uploadUrl, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });

        const currentImages = props.modelValue ? [...props.modelValue] : [];
        currentImages.push(response.data.path);
        emit('update:modelValue', currentImages);
    } catch (error) {
        console.error('Upload failed:', error);
    } finally {
        uploading.value = false;
    }
};

const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const files = target.files;

    if (files) {
        for (let i = 0; i < files.length; i++) {
            await uploadFile(files[i]);
        }
    }
};

const removeImage = (index: number) => {
    if (!props.modelValue) return;
    const currentImages = [...props.modelValue];
    currentImages.splice(index, 1);
    emit('update:modelValue', currentImages.length > 0 ? currentImages : null);
};

const { isOverDropZone } = useDropZone(dropZoneRef, async (files) => {
    if (files && files.length > 0) {
        for (const file of files) {
            await uploadFile(file);
        }
    }
});
</script>

<template>
    <div>
        <label v-if="label" class="mb-2 block text-sm font-medium">
            {{ label }}
        </label>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            <div
                v-for="(image, index) in modelValue"
                :key="index"
                class="group relative aspect-square overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <img
                    :src="image"
                    alt="Gallery Image"
                    class="h-full w-full object-cover transition-opacity group-hover:opacity-90"
                />
                <button
                    type="button"
                    @click="removeImage(index)"
                    class="absolute top-2 right-2 flex h-8 w-8 items-center justify-center rounded-lg bg-red-600 text-white shadow-lg transition-transform hover:scale-105 hover:bg-red-700 active:scale-95"
                    title="Remove image"
                >
                    <Trash2 class="h-4 w-4" />
                </button>
            </div>

            <div
                ref="dropZoneRef"
                @click="fileInput?.click()"
                class="relative flex aspect-square cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed transition-all"
                :class="[
                    isOverDropZone
                        ? 'border-primary bg-primary/5'
                        : 'border-sidebar-border/70 hover:border-primary/50 hover:bg-sidebar-accent/30 dark:border-sidebar-border',
                    uploading ? 'pointer-events-none opacity-50' : '',
                ]"
            >
                <div class="flex flex-col items-center gap-2 text-center p-4">
                    <div
                        class="rounded-full bg-sidebar-accent p-2 text-muted-foreground transition-colors group-hover:text-primary"
                    >
                        <Upload v-if="!uploading" class="h-6 w-6" />
                        <div
                            v-else
                            class="h-6 w-6 animate-spin rounded-full border-2 border-primary border-t-transparent"
                        ></div>
                    </div>
                    <div>
                        <p class="text-sm font-medium">
                            {{
                                uploading
                                    ? 'Uploading...'
                                    : 'Add Image'
                            }}
                        </p>
                        <p class="text-[10px] text-muted-foreground">
                            PNG, JPG or WEBP
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <input
            type="file"
            ref="fileInput"
            accept="image/*"
            multiple
            @change="handleFileUpload"
            class="hidden"
        />

        <div
            v-if="error"
            class="mt-2 flex items-center gap-1.5 text-sm text-red-600"
        >
            <X class="h-3.5 w-3.5" />
            <span>{{ error }}</span>
        </div>
    </div>
</template>
