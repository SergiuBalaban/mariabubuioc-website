<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

import RichTextEditor from '@/components/RichTextEditor.vue';
import UploadCover from '@/components/UploadCover.vue';
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
        <div
            class="mx-auto flex h-full max-w-6xl flex-1 flex-col gap-4 space-y-6 rounded-xl p-4"
        >
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
                        <UploadCover
                            v-model="form.cover"
                            upload-url="/admin/projects/upload-cover"
                            :error="form.errors.cover"
                            label="Cover Image"
                        />

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
