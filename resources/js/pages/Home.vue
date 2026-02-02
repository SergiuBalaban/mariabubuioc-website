<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

import ProjectFilters from '@/components/ProjectFilters.vue';
import { detail as projectDetail } from '@/routes/project';

import Sidebar from './Sidebar.vue';

const props = defineProps<{
    projects: {
        data: Array<{
            id: number;
            title: string;
            category_name: string;
            cover: string;
        }>;
    };
}>();

const activeFilter = ref('*');

const categories = computed(() => {
    const uniqueCategories = [...new Set(props.projects.data.map(p => p.category_name))];
    return [
        { label: 'All', value: '*' },
        ...uniqueCategories.map(cat => ({ label: cat, value: cat }))
    ];
});

const filteredProjects = computed(() => {
    if (activeFilter.value === '*') {
        return props.projects.data;
    }
    return props.projects.data.filter(project => project.category_name === activeFilter.value);
});

const handleFilterChange = (filter: string) => {
    activeFilter.value = filter;
};
</script>

<template>
    <Head title="Home" />
    <div class="min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
        <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-64">
                <Sidebar />
                <div class="p-6">
                    <ProjectFilters
                        :active-filter="activeFilter"
                        :categories="categories"
                        @filter-change="handleFilterChange"
                    />
                </div>
            </div>

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div id="works-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <Link
                        v-for="project in filteredProjects"
                        :key="project.id"
                        :href="projectDetail.url(project.id)"
                        class="group relative block overflow-hidden rounded-lg shadow-sm transition-all hover:shadow-md"
                    >
                        <div class="aspect-9/5 w-full overflow-hidden bg-gray-100 dark:bg-gray-800">
                            <img
                                :src="project.cover"
                                :alt="project.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                            <div class="text-center text-white">
                                <h2 class="text-xl font-bold">{{ project.title }}</h2>
                                <p class="text-sm">{{ project.category_name }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </main>
        </div>
    </div>
</template>
