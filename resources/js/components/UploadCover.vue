<script setup lang="ts">
import { useDropZone } from '@vueuse/core';
import axios from 'axios';
import { Upload, X } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    modelValue: string | null;
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
    formData.append('cover', file);

    try {
        const response = await axios.post(props.uploadUrl, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        emit('update:modelValue', response.data.path);
    } catch (error) {
        console.error('Upload failed:', error);
    } finally {
        uploading.value = false;
    }
};

const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        await uploadFile(file);
    }
};

const { isOverDropZone } = useDropZone(dropZoneRef, async (files) => {
    if (files && files.length > 0) {
        await uploadFile(files[0]);
    }
});
</script>

<template>
    <div>
        <label v-if="label" class="mb-2 block text-sm font-medium">
            {{ label }}
        </label>

        <div v-if="modelValue" class="group relative">
            <img
                :src="modelValue"
                alt="Cover"
                class="mb-2 h-96 w-full rounded-xl object-cover shadow-sm transition-opacity group-hover:opacity-90"
            />
            <button
                type="button"
                @click="emit('update:modelValue', null)"
                class="absolute top-4 right-4 flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-lg transition-transform hover:scale-105 hover:bg-red-700 active:scale-95"
                title="Remove cover"
            >
                <X class="h-4 w-4" />
                <span>Remove cover</span>
            </button>
        </div>

        <div v-else>
            <div
                ref="dropZoneRef"
                @click="fileInput?.click()"
                class="relative mb-2 flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed transition-all"
                :class="[
                    isOverDropZone
                        ? 'border-primary bg-primary/5'
                        : 'border-sidebar-border/70 hover:border-primary/50 hover:bg-sidebar-accent/30 dark:border-sidebar-border',
                    uploading ? 'pointer-events-none opacity-50' : '',
                ]"
            >
                <div class="flex flex-col items-center gap-3 text-center">
                    <div
                        class="rounded-full bg-sidebar-accent p-3 text-muted-foreground transition-colors group-hover:text-primary"
                    >
                        <Upload v-if="!uploading" class="h-8 w-8" />
                        <div
                            v-else
                            class="h-8 w-8 animate-spin rounded-full border-2 border-primary border-t-transparent"
                        ></div>
                    </div>
                    <div>
                        <p class="font-medium">
                            {{
                                uploading
                                    ? 'Uploading...'
                                    : 'Click to upload or drag and drop'
                            }}
                        </p>
                        <p class="text-xs text-muted-foreground">
                            PNG, JPG or WEBP (max. 5MB)
                        </p>
                    </div>
                </div>
            </div>
            <input
                type="file"
                ref="fileInput"
                accept="image/*"
                @change="handleFileUpload"
                class="hidden"
            />
        </div>

        <div
            v-if="error"
            class="mt-2 flex items-center gap-1.5 text-sm text-red-600"
        >
            <X class="h-3.5 w-3.5" />
            <span>{{ error }}</span>
        </div>
    </div>
</template>
