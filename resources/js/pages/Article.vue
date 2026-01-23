<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { about, blog, home } from '@/routes';
import { page as homePage } from '@/routes/home';

defineProps<{
    article: {
        data: {
            id: number;
            title: string;
            author: string;
            cover: string;
            content: {
                description: string;
                category: string;
                date: string;
                content_ro?: string;
                content_en?: string;
                images?: string[];
                [key: string]: any;
            };
        };
    }
}>();
</script>

<template>
    <Head :title="article.data.title" />
    <div class="min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
        <div class="flex flex-col lg:flex-row">
            <aside id="sidebar" class="w-full lg:w-64 p-6 border-b lg:border-b-0 lg:border-r border-[#19140015] dark:border-[#3E3E3A]">
                <div class="sticky top-6">
                    <h2 class="text-xl font-bold mb-4">Maria Bubuioc</h2>
                    <nav class="space-y-2">
                        <Link :href="home().url" class="block hover:underline">Welcome</Link>
                        <Link :href="homePage().url" class="block hover:underline">Works</Link>
                        <Link :href="about().url" class="block hover:underline">About</Link>
                        <Link :href="blog().url" class="block font-bold">Blog</Link>
                    </nav>
                </div>
            </aside>

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div class="max-w-4xl mx-auto">
                    <article>
                        <div class="mb-8 overflow-hidden rounded-lg shadow-sm aspect-[16/9]">
                            <img :src="article.data.cover" :alt="article.data.title" class="h-full w-full object-cover" />
                        </div>

                        <div class="mb-8">
                            <h2 class="text-4xl font-bold mb-4">{{ article.data.title }}</h2>
                            <ul class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                <li class="author">{{ article.data.author }}</li>
                                <li class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></li>
                                <li class="time">{{ article.data.content.date }}</li>
                                <li class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></li>
                                <li class="categories">
                                    <span class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-xs uppercase tracking-wider font-semibold">{{ article.data.content.category }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-12">
                            <!-- Romanian Content -->
                            <div v-if="article.data.content.content_ro" class="prose dark:prose-invert max-w-none">
                                <p class="lead font-bold text-lg mb-4 text-gray-600 dark:text-gray-400">[RO]</p>
                                <div class="space-y-6 text-lg leading-relaxed" v-html="article.data.content.content_ro"></div>
                            </div>

                            <!-- Images from Article (if any) -->
                            <div v-if="article.data.content.images && article.data.content.images.length > 0" class="grid grid-cols-1 gap-8 my-12">
                                <img v-for="(img, idx) in article.data.content.images" :key="idx" :src="img" class="rounded-lg shadow-sm w-full" />
                            </div>

                            <!-- English Content -->
                            <div v-if="article.data.content.content_en" class="prose dark:prose-invert max-w-none pb-12">
                                <p class="lead font-bold text-lg mb-4 text-gray-600 dark:text-gray-400">[EN]</p>
                                <div class="space-y-6 text-lg leading-relaxed" v-html="article.data.content.content_en"></div>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
</template>
