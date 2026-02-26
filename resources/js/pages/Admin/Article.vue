<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

import RichTextEditor from '@/components/RichTextEditor.vue';
import UploadCover from '@/components/UploadCover.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Blog {
    id: number;
    cover: string | null;
    title: string;
    content: any | null;
    created_at: string;
    updated_at: string;
}

interface ArticleProps {
    blog?: Blog;
}

const props = defineProps<ArticleProps>();

const isEditing = computed(() => !!props.blog);

// Helper to handle initial content value
const getInitialContent = (content: any) => {
    if (!content) return '';
    if (typeof content === 'string') return content;
    // If it's an array/object (legacy JSON), stringify it so it's at least visible,
    // though ideally this should be migrated to HTML.
    return JSON.stringify(content, null, 2);
};

const form = useForm({
    cover: props.blog?.cover || null,
    title: props.blog?.title || '',
    content: getInitialContent(props.blog?.content),
});

const submit = () => {
    if (isEditing.value && props.blog) {
        const data: Record<string, any> = {};

        if (form.title !== props.blog.title) data.title = form.title;
        if (form.cover !== props.blog.cover) data.cover = form.cover;

        if (form.content !== getInitialContent(props.blog.content)) {
            data.content = form.content;
        }

        form.transform(() => data).put(`/admin/blogs/${props.blog!.id}`);
    } else {
        form.post('/admin/blogs');
    }
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
        title: isEditing.value && props.blog ? props.blog.title : 'Create',
        href:
            isEditing.value && props.blog
                ? `/admin/blogs/${props.blog.id}`
                : '/admin/blogs/create',
    },
];
</script>

<template>
    <Head :title="isEditing ? `Edit - ${blog?.title}` : 'Create Blog'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="mx-auto flex h-full max-w-6xl flex-1 flex-col gap-4 space-y-6 rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">
                    {{ isEditing ? 'Edit Blog' : 'Create Blog' }}
                </h1>
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
                        <UploadCover
                            v-model="form.cover"
                            upload-url="/admin/blogs/upload-cover"
                            :error="form.errors.cover"
                            label="Cover Image"
                        />

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
                            <label class="mb-2 block text-sm font-medium">
                                Content
                            </label>
                            <RichTextEditor
                                v-model="form.content"
                                upload-url="/admin/blogs/upload-cover"
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
                        {{
                            form.processing
                                ? 'Saving...'
                                : isEditing
                                  ? 'Save Changes'
                                  : 'Create Blog'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
