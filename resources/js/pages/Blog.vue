<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { article as blogArticle } from '@/routes/blog';

import Sidebar from './Sidebar.vue';

const props = defineProps<{
    articles: {
        data: Array<{
            id: number;
            title: string;
            cover: string;
            content: string;
            created_at: string;
            updated_at: string;
        }>;
    };
}>();
</script>

<template>
    <Head title="Blog" />
    <div
        class="min-h-screen bg-white text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
    >
        <div class="flex flex-col lg:flex-row">
            <Sidebar />

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div class="mx-auto max-w-4xl space-y-16">
                    <article
                        v-for="article in props.articles.data"
                        :key="article.id"
                        class="group"
                    >
                        <div class="flex flex-col gap-8">
                            <Link
                                :href="blogArticle.url(article.id)"
                                class="relative block aspect-video overflow-hidden rounded-lg shadow-sm transition-all hover:shadow-md"
                            >
                                <img
                                    :src="article.cover"
                                    :alt="article.title"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                >
                                    <i class="icon-eye text-4xl text-white"></i>
                                </div>
                            </Link>
                            <div class="space-y-4">
                                <Link
                                    :href="blogArticle.url(article.id)"
                                    class="block"
                                >
                                    <h2
                                        class="text-3xl font-bold transition-colors group-hover:text-gray-600 dark:group-hover:text-gray-400"
                                    >
                                        {{ article.title }}
                                    </h2>
                                </Link>
                                <div
                                    class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400"
                                >
                                    <span class="author">{{
                                        article.created_at
                                    }}</span>
                                    <span
                                        class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"
                                    ></span>
                                    <span class="category">Uncategorized</span>
                                </div>
                                <div
                                    class="line-clamp-2 text-lg leading-relaxed"
                                    v-html="article.content"
                                ></div>
                                <Link
                                    :href="blogArticle.url(article.id)"
                                    class="inline-block border-b-2 border-transparent font-bold transition-all hover:border-current"
                                >
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
