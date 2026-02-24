<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useDropZone } from '@vueuse/core';
import axios from 'axios';
import { Upload, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

import RichTextEditor from '@/components/RichTextEditor.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Category {
    id: number;
    name: string;
}

interface Project {
    id: number;
    category_id: number;
    title: string;
    cover: string | null;
    price: string | null;
    content: any | null;
    created_at: string;
    updated_at: string;
}

interface ProjectProps {
    project?: Project;
    categories: Category[];
}

const props = defineProps<ProjectProps>();

const isEditing = computed(() => !!props.project);

// Helper to handle initial content value
const getInitialContent = (content: any) => {
    if (!content) return '';
    if (typeof content === 'string') return content;
    return JSON.stringify(content, null, 2);
};

const form = useForm({
    category_id: props.project?.category_id || '',
    title: props.project?.title || '',
    cover: props.project?.cover || null,
    price: props.project?.price || '',
    content: getInitialContent(props.project?.content),
});

const uploading = ref(false);
const dropZoneRef = ref<HTMLDivElement | null>(null);

const uploadFile = async (file: File) => {
    if (!file) return;

    uploading.value = true;
    const formData = new FormData();
    formData.append('cover', file);

    try {
        const response = await axios.post(
            '/admin/projects/upload-cover',
            formData,
            {
                headers: { 'Content-Type': 'multipart/form-data' },
            },
        );
        form.cover = response.data.path;
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

const submit = () => {
    if (isEditing.value && props.project) {
        const data: Record<string, any> = {};

        if (form.category_id !== props.project.category_id)
            data.category_id = form.category_id;
        if (form.title !== props.project.title) data.title = form.title;
        if (form.cover !== props.project.cover) data.cover = form.cover;
        if (form.price !== props.project.price) data.price = form.price;

        if (form.content !== getInitialContent(props.project.content)) {
            data.content = form.content;
        }

        form.transform(() => data).put(`/admin/projects/${props.project!.id}`);
    } else {
        form.post('/admin/projects');
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Projects',
        href: '/admin/projects',
    },
    {
        title:
            isEditing.value && props.project ? props.project.title : 'Create',
        href:
            isEditing.value && props.project
                ? `/admin/projects/${props.project.id}`
                : '/admin/projects/create',
    },
];
</script>

<template>
    <Head :title="isEditing ? `Edit - ${project?.title}` : 'Create Project'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">
                    {{ isEditing ? 'Edit Project' : 'Create Project' }}
                </h1>
                <Link
                    href="/admin/projects"
                    class="rounded bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700"
                >
                    Back to Projects
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div
                    class="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
                >
                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Cover Image
                            </label>

                            <div v-if="form.cover" class="group relative">
                                <img
                                    :src="form.cover"
                                    alt="Cover"
                                    class="mb-2 h-96 w-full rounded-xl object-cover shadow-sm transition-opacity group-hover:opacity-90"
                                />
                                <button
                                    type="button"
                                    @click="form.cover = null"
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
                                    @click="$refs.fileInput.click()"
                                    class="relative mb-2 flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed transition-all"
                                    :class="[
                                        isOverDropZone
                                            ? 'border-primary bg-primary/5'
                                            : 'border-sidebar-border/70 hover:border-primary/50 hover:bg-sidebar-accent/30 dark:border-sidebar-border',
                                        uploading
                                            ? 'pointer-events-none opacity-50'
                                            : '',
                                    ]"
                                >
                                    <div
                                        class="flex flex-col items-center gap-3 text-center"
                                    >
                                        <div
                                            class="rounded-full bg-sidebar-accent p-3 text-muted-foreground transition-colors group-hover:text-primary"
                                        >
                                            <Upload
                                                v-if="!uploading"
                                                class="h-8 w-8"
                                            />
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
                                            <p
                                                class="text-xs text-muted-foreground"
                                            >
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
                                v-if="form.errors.cover"
                                class="mt-2 flex items-center gap-1.5 text-sm text-red-600"
                            >
                                <X class="h-3.5 w-3.5" />
                                <span>{{ form.errors.cover }}</span>
                            </div>
                        </div>

                        <div>
                            <label
                                for="category"
                                class="mb-2 block text-sm font-medium"
                            >
                                Category *
                            </label>
                            <select
                                id="category"
                                v-model="form.category_id"
                                required
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 dark:border-sidebar-border"
                            >
                                <option value="" disabled>
                                    Select a category
                                </option>
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.category_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.category_id }}
                            </div>
                        </div>

                        <div>
                            <label
                                for="title"
                                class="mb-2 block text-sm font-medium"
                            >
                                Title *
                            </label>
                            <input
                                id="title"
                                v-model="form.title"
                                type="text"
                                required
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 dark:border-sidebar-border"
                            />
                            <div
                                v-if="form.errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.title }}
                            </div>
                        </div>

                        <div>
                            <label
                                for="price"
                                class="mb-2 block text-sm font-medium"
                            >
                                Price
                            </label>
                            <input
                                id="price"
                                v-model="form.price"
                                type="text"
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 dark:border-sidebar-border"
                            />
                            <div
                                v-if="form.errors.price"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.price }}
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Content
                            </label>
                            <RichTextEditor
                                v-model="form.content"
                                upload-url="/admin/projects/upload-cover"
                            />
                            <div
                                v-if="form.errors.content"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.content }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link
                        href="/admin/projects"
                        class="rounded border border-sidebar-border/70 px-4 py-2 text-sm hover:bg-sidebar-accent dark:border-sidebar-border"
                    >
                        Cancel
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                    >
                        {{
                            form.processing
                                ? 'Saving...'
                                : isEditing
                                  ? 'Save Changes'
                                  : 'Create Project'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
