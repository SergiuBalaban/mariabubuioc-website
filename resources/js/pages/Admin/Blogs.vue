<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Blog {
    id: number;
    title: string;
    created_at: string;
    updated_at: string;
}

interface BlogsProps {
    blogs: {
        data: Blog[];
        links: Array<{
            first: string | null;
            last: string | null;
            prev: string | null;
            next: string | null;
        }>;
        meta: Array<{
            current_page: number;
            from: number;
            last_page: number;
            links: Array<{
                url: string | null;
                label: string | null;
                page: number;
                active: boolean;
            }>;
            path: string | null;
            per_page: number;
            to: number;
            total: number;
        }>;
    };
}

defineProps<BlogsProps>();

const deleteBlog = (blog: Blog) => {
    if (confirm(`Are you sure you want to delete "${blog.title}"?`)) {
        router.delete(`/admin/blogs/${blog.id}`);
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
];
</script>

<template>
    <Head title="Admin - Blogs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Blogs</h1>
                <Link
                    href="/admin/blogs/create"
                    class="rounded bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90"
                >
                    Create Article
                </Link>
            </div>

            <div
                class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead
                            class="border-b border-sidebar-border/70 dark:border-sidebar-border"
                        >
                            <tr>
                                <th class="px-4 py-3 text-left font-medium">
                                    ID
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Title
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Created
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Updated
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="blog in blogs.data"
                                :key="blog.id"
                                class="border-b border-sidebar-border/70 last:border-b-0 dark:border-sidebar-border"
                            >
                                <td class="px-4 py-3">{{ blog.id }}</td>
                                <td class="px-4 py-3 font-medium">
                                    <Link
                                        :href="`/admin/blogs/${blog.id}`"
                                        class="hover:text-primary hover:underline"
                                    >
                                        {{ blog.title }}
                                    </Link>
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            blog.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            blog.updated_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-4 py-3">
                                    <button
                                        data-test="delete-blog-button-{{ blog.id }}"
                                        @click="deleteBlog(blog)"
                                        class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    v-if="blogs.meta.last_page > 1"
                    class="flex items-center justify-between border-t border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                >
                    <div class="text-sm text-muted-foreground">
                        Showing
                        {{
                            (blogs.meta.current_page - 1) *
                                blogs.meta.per_page +
                            1
                        }}
                        to
                        {{
                            Math.min(
                                blogs.meta.current_page * blogs.meta.per_page,
                                blogs.meta.total,
                            )
                        }}
                        of {{ blogs.meta.total }} results
                    </div>
                    <div class="flex items-center gap-2">
                        <Link
                            v-for="link in blogs.meta.links"
                            :key="link.label"
                            :href="link.url || '#'"
                            :class="[
                                'rounded border px-3 py-1 text-sm',
                                link.active
                                    ? 'border-primary bg-primary text-primary-foreground'
                                    : 'border-sidebar-border/70 hover:bg-sidebar-accent dark:border-sidebar-border',
                                !link.url
                                    ? 'cursor-not-allowed opacity-50'
                                    : '',
                            ]"
                            :disabled="!link.url"
                        >
                            {{ link.label }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
