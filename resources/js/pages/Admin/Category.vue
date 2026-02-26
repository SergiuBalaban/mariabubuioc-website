<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

interface Category {
    id: number;
    name: string;
}

interface CategoryProps {
    category?: Category;
}

const props = defineProps<CategoryProps>();

const isEditing = computed(() => !!props.category);

const form = useForm({
    name: props.category?.name || '',
});

const submit = () => {
    if (isEditing.value && props.category) {
        form.put(`/admin/categories/${props.category.id}`);
    } else {
        form.post('/admin/categories');
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
    {
        title:
            isEditing.value && props.category ? props.category.name : 'Create',
        href:
            isEditing.value && props.category
                ? `/admin/categories/${props.category.id}`
                : '/admin/categories/create',
    },
];
</script>

<template>
    <Head :title="isEditing ? `Edit - ${category?.name}` : 'Create Category'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">
                    {{ isEditing ? 'Edit Category' : 'Create Category' }}
                </h1>
                <Link
                    href="/admin/categories"
                    class="rounded bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700"
                >
                    Back to Categories
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div
                    class="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
                >
                    <div class="space-y-4">
                        <div>
                            <label
                                for="name"
                                class="mb-2 block text-sm font-medium"
                            >
                                Name *
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full rounded border border-sidebar-border/70 bg-transparent px-3 py-2 dark:border-sidebar-border"
                            />
                            <div
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link
                        href="/admin/categories"
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
                                  : 'Create Category'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
