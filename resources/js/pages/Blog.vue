<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { about, blog, home } from '@/routes';
import { article as blogArticle } from '@/routes/blog';
import { page as homePage } from '@/routes/home';

const props = defineProps<{
    articles: {
        data: Array<{
            id: number;
            title: string;
            author: string;
            cover: string;
            content: {
                description: string;
                category: string;
                [key: string]: any;
            };
        }>;
    };
}>();
</script>

<template>
    <Head title="Blog" />
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
                <div class="max-w-4xl mx-auto space-y-16">
                    <article v-for="article in props.articles.data" :key="article.id" class="group">
                        <div class="flex flex-col gap-8">
                            <Link :href="blogArticle.url(article.id)" class="block overflow-hidden rounded-lg shadow-sm transition-all hover:shadow-md aspect-[16/9] relative">
                                <img
                                    :src="article.cover"
                                    :alt="article.title"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <div class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <i class="icon-eye text-white text-4xl"></i>
                                </div>
                            </Link>
                            <div class="space-y-4">
                                <Link :href="blogArticle.url(article.id)" class="block">
                                    <h2 class="text-3xl font-bold group-hover:text-gray-600 dark:group-hover:text-gray-400 transition-colors">{{ article.title }}</h2>
                                </Link>
                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="author">{{ article.author }}</span>
                                    <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                                    <span class="category">{{ article.content.category }}</span>
                                </div>
                                <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                                    {{ article.content.description }}
                                </p>
                                <Link :href="blogArticle.url(article.id)" class="inline-block font-bold border-b-2 border-transparent hover:border-current transition-all">
                                    Read More
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
</template>
