<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Category {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

interface CategoriesProps {
    categories: {
        data: Category[];
        links: Array<{
            first: string | null;
            last: string | null;
            prev: string | null;
            next: string | null;
        }>;
        meta: {
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
        };
    };
}

defineProps<CategoriesProps>();

const deleteCategory = (category: Category) => {
    if (
        confirm(`Are you sure you want to delete category "${category.name}"?`)
    ) {
        router.delete(`/admin/categories/${category.id}`);
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Categories',
        href: '/admin/categories',
    },
];
</script>

<template>
    <Head title="Admin - Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full max-w-6xl flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Categories</h1>
                <Link
                    href="/admin/categories/create"
                    class="rounded bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90"
                >
                    Create Category
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
                                    Name
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Created
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="category in categories.data"
                                :key="category.id"
                                class="border-b border-sidebar-border/70 last:border-b-0 dark:border-sidebar-border"
                            >
                                <td class="px-4 py-3">{{ category.id }}</td>
                                <td class="px-4 py-3 font-medium">
                                    <Link
                                        :href="`/admin/categories/${category.id}`"
                                        class="hover:text-primary hover:underline"
                                    >
                                        {{ category.name }}
                                    </Link>
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            category.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-4 py-3">
                                    <button
                                        @click="deleteCategory(category)"
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
                    v-if="categories.meta.last_page > 1"
                    class="flex items-center justify-between border-t border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                >
                    <div class="text-sm text-muted-foreground">
                        Showing
                        {{
                            (categories.meta.current_page - 1) *
                                categories.meta.per_page +
                            1
                        }}
                        to
                        {{
                            Math.min(
                                categories.meta.current_page *
                                    categories.meta.per_page,
                                categories.meta.total,
                            )
                        }}
                        of {{ categories.meta.total }} results
                    </div>
                    <div class="flex items-center gap-2">
                        <Link
                            v-for="link in categories.meta.links"
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
                            <span v-html="link.label"></span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
