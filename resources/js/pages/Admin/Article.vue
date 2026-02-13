<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Blog {
    id: number;
    cover: string | null;
    title: string;
    author: string | null;
    content: any[] | null;
    details: any[] | null;
    created_at: string;
    updated_at: string;
}

interface ArticleProps {
    blog: Blog;
}

const props = defineProps<ArticleProps>();

const form = useForm({
    cover: props.blog.cover,
    title: props.blog.title,
    author: props.blog.author,
    content: JSON.stringify(props.blog.content, null, 2),
    details: JSON.stringify(props.blog.details, null, 2),
});

const submit = () => {
    const data: Record<string, any> = {};

    if (form.title !== props.blog.title) data.title = form.title;
    if (form.author !== props.blog.author) data.author = form.author;
    if (form.cover !== props.blog.cover) data.cover = form.cover;

    const originalContent = JSON.stringify(props.blog.content, null, 2);
    if (form.content !== originalContent) {
        data.content = form.content ? JSON.parse(form.content) : null;
    }

    const originalDetails = JSON.stringify(props.blog.details, null, 2);
    if (form.details !== originalDetails) {
        data.details = form.details ? JSON.parse(form.details) : null;
    }

    form.transform(() => data).put(`/admin/blogs/${props.blog.id}`);
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Blogs',
        href: '/admin/blogs',
    },
    {
        title: props.blog.title,
        href: `/admin/blogs/${props.blog.id}`,
    },
];
</script>

<template>
    <Head :title="`Edit - ${blog.title}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Edit Blog</h1>
                <Link
                    href="/admin/blogs"
                    class="rounded bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700"
                >
                    Back to Blogs
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
                            <div v-if="form.cover" class="mb-2">
                                <img
                                    :src="form.cover"
                                    alt="Cover"
                                    class="h-96 w-full rounded object-cover"
                                />
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
                                for="author"
                                class="mb-2 block text-sm font-medium"
                            >
                                Author
                            </label>
                            <input
                                id="author"
                                v-model="form.author"
                                type="text"
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 dark:border-sidebar-border"
                            />
                            <div
                                v-if="form.errors.author"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.author }}
                            </div>
                        </div>

                        <div>
                            <label
                                for="content"
                                class="mb-2 block text-sm font-medium"
                            >
                                Content (JSON)
                            </label>
                            <textarea
                                id="content"
                                v-model="form.content"
                                rows="10"
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 font-mono text-sm dark:border-sidebar-border"
                            />
                            <div
                                v-if="form.errors.content"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.content }}
                            </div>
                        </div>

                        <div>
                            <label
                                for="details"
                                class="mb-2 block text-sm font-medium"
                            >
                                Details (JSON)
                            </label>
                            <textarea
                                id="details"
                                v-model="form.details"
                                rows="10"
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 font-mono text-sm dark:border-sidebar-border"
                            />
                            <div
                                v-if="form.errors.details"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.details }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link
                        href="/admin/blogs"
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
