<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Project {
    id: number;
    title: string;
    category_name: string;
    price: string | null;
    created_at: string;
    updated_at: string;
}

interface ProjectsProps {
    projects: {
        data: Project[];
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

defineProps<ProjectsProps>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Projects',
        href: '/admin/projects',
    },
];
</script>

<template>
    <Head title="Admin - Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Projects</h1>
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
                                    Category
                                </th>
                                <th class="px-4 py-3 text-left font-medium">
                                    Price
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
                                v-for="project in projects.data"
                                :key="project.id"
                                class="border-b border-sidebar-border/70 last:border-b-0 dark:border-sidebar-border"
                            >
                                <td class="px-4 py-3">{{ project.id }}</td>
                                <td class="px-4 py-3 font-medium">
                                    <Link
                                        :href="`/admin/projects/${project.id}`"
                                        class="hover:text-primary hover:underline"
                                    >
                                        {{ project.title }}
                                    </Link>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ project.category_name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ project.price }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            project.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            project.updated_at,
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-4 py-3">
                                    <!-- Actions will be added later -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    v-if="projects.meta.last_page > 1"
                    class="flex items-center justify-between border-t border-sidebar-border/70 px-4 py-3 dark:border-sidebar-border"
                >
                    <div class="text-sm text-muted-foreground">
                        Showing
                        {{
                            (projects.meta.current_page - 1) *
                                projects.meta.per_page +
                            1
                        }}
                        to
                        {{
                            Math.min(
                                projects.meta.current_page * projects.meta.per_page,
                                projects.meta.total,
                            )
                        }}
                        of {{ projects.meta.total }} results
                    </div>
                    <div class="flex items-center gap-2">
                        <Link
                            v-for="link in projects.meta.links"
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
