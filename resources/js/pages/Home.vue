<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { about, blog, home } from '@/routes';
import { page as homePage } from '@/routes/home';
import { detail as projectDetail } from '@/routes/project';

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
</script>

<template>
    <Head title="Home" />
    <div class="min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
        <div class="flex flex-col lg:flex-row">
            <!-- Sidebar placeholder (since the original code has includes/sidebar and includes/projects-filter) -->
            <aside id="sidebar" class="w-full lg:w-64 p-6 border-b lg:border-b-0 lg:border-r border-[#19140015] dark:border-[#3E3E3A]">
                <div class="sticky top-6">
                    <h2 class="text-xl font-bold mb-4">Maria Bubuioc</h2>
                    <nav class="space-y-2">
                        <Link :href="home().url" class="block hover:underline">Welcome</Link>
                        <Link :href="homePage().url" class="block font-bold">Works</Link>
                        <Link :href="about().url" class="block hover:underline">About</Link>
                        <Link :href="blog().url" class="block hover:underline">Blog</Link>
                    </nav>
                </div>
            </aside>

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div id="works-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <Link
                        v-for="project in props.projects.data"
                        :key="project.id"
                        :href="projectDetail.url(project.id)"
                        class="group relative block overflow-hidden rounded-lg shadow-sm transition-all hover:shadow-md"
                    >
                        <div class="aspect-[9/5] w-full overflow-hidden bg-gray-100 dark:bg-gray-800">
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
