<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Trash2 } from 'lucide-vue-next';
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
    details: any | null;
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

const getInitialDetails = (details: any) => {
    if (!details || typeof details !== 'object' || Array.isArray(details))
        return [];
    return Object.entries(details).map(([key, value]) => ({
        key,
        value: String(value),
    }));
};

const transformDetails = (details: { key: string; value: string }[]) => {
    const obj: Record<string, any> = {};
    details.forEach((item) => {
        if (item.key.trim()) {
            obj[item.key.trim()] = item.value;
        }
    });
    return obj;
};

const form = useForm({
    category_id: props.project?.category_id || '',
    title: props.project?.title || '',
    cover: props.project?.cover || null,
    price: props.project?.price || '',
    details: getInitialDetails(props.project?.details),
    content: getInitialContent(props.project?.content),
});

const submit = () => {
    const transformedDetails = transformDetails(form.details);

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

        if (
            JSON.stringify(transformedDetails) !==
            JSON.stringify(props.project.details || {})
        ) {
            data.details = transformedDetails;
        }

        form.transform(() => data).put(`/admin/projects/${props.project!.id}`);
    } else {
        form.transform((data) => ({
            ...data,
            details: transformedDetails,
        })).post('/admin/projects');
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
                            <div class="mb-2 flex items-center justify-between">
                                <label class="text-sm font-medium">
                                    Details
                                </label>
                                <button
                                    type="button"
                                    @click="
                                        form.details.push({
                                            key: '',
                                            value: '',
                                        })
                                    "
                                    class="flex items-center gap-1 text-xs text-primary hover:underline"
                                >
                                    <Plus class="h-3 w-3" /> Add Detail
                                </button>
                            </div>
                            <div class="space-y-2">
                                <div
                                    v-for="(detail, index) in form.details"
                                    :key="index"
                                    class="flex items-start gap-2"
                                >
                                    <div class="flex-1">
                                        <input
                                            v-model="detail.key"
                                            type="text"
                                            placeholder="Label (e.g., Year)"
                                            class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 text-sm dark:border-sidebar-border"
                                        />
                                    </div>
                                    <div class="flex-[2]">
                                        <input
                                            v-model="detail.value"
                                            type="text"
                                            placeholder="Value (e.g., 2024)"
                                            class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 text-sm dark:border-sidebar-border"
                                        />
                                    </div>
                                    <button
                                        type="button"
                                        @click="form.details.splice(index, 1)"
                                        class="rounded p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20"
                                        title="Remove detail"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    v-if="form.details.length === 0"
                                    class="py-2 text-xs italic text-muted-foreground"
                                >
                                    No details added yet.
                                </div>
                            </div>
                            <div
                                v-if="form.errors.details"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.details }}
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
