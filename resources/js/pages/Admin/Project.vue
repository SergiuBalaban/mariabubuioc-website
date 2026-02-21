<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

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
    project: Project;
    categories: Category[];
}

const props = defineProps<ProjectProps>();

// Helper to handle initial content value
const getInitialContent = (content: any) => {
    if (!content) return '';
    if (typeof content === 'string') return content;
    return JSON.stringify(content, null, 2);
};

const form = useForm({
    category_id: props.project.category_id,
    title: props.project.title,
    cover: props.project.cover,
    price: props.project.price,
    content: getInitialContent(props.project.content),
});

const uploading = ref(false);

const handleFileUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

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

const submit = () => {
    const data: Record<string, any> = {};

    if (form.category_id !== props.project.category_id) data.category_id = form.category_id;
    if (form.title !== props.project.title) data.title = form.title;
    if (form.cover !== props.project.cover) data.cover = form.cover;
    if (form.price !== props.project.price) data.price = form.price;

    if (form.content !== getInitialContent(props.project.content)) {
        data.content = form.content;
    }

    form.transform(() => data).put(`/admin/projects/${props.project.id}`);
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
        title: props.project.title,
        href: `/admin/projects/${props.project.id}`,
    },
];
</script>

<template>
    <Head :title="`Edit - ${project.title}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Edit Project</h1>
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
                            <div v-if="form.cover">
                                <img
                                    :src="form.cover"
                                    alt="Cover"
                                    class="mb-2 h-96 w-full rounded object-cover"
                                />
                                <button
                                    type="button"
                                    @click="form.cover = null"
                                    class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700"
                                >
                                    Remove cover
                                </button>
                            </div>
                            <div v-else>
                                <div
                                    class="mb-2 flex h-48 w-full items-center justify-center rounded border-2 border-dashed border-sidebar-border/70 dark:border-sidebar-border"
                                >
                                    <div class="text-center">
                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            No cover image
                                        </p>
                                    </div>
                                </div>
                                <input
                                    type="file"
                                    accept="image/*"
                                    @change="handleFileUpload"
                                    :disabled="uploading"
                                    class="w-full text-sm"
                                />
                                <p
                                    v-if="uploading"
                                    class="mt-1 text-sm text-blue-600"
                                >
                                    Uploading...
                                </p>
                            </div>
                            <div
                                v-if="form.errors.cover"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.cover }}
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
                            >
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
                            >
                            <div
                                v-if="form.errors.price"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.price }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="mb-2 block text-sm font-medium"
                            >
                                Content
                            </label>
                            <RichTextEditor v-model="form.content" />
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
                        {{ form.processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
