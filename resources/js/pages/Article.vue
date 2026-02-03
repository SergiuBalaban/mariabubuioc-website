<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Sidebar from './Sidebar.vue';

defineProps<{
    article: {
        data: {
            id: number;
            title: string;
            author: string;
            cover: string;
            details: {
                description: string;
                category: string;
                date: string;
                content_ro?: string;
                content_en?: string;
                images?: string[];
                [key: string]: any;
            };
            content: string;
        };
    };
}>();
</script>

<template>
    <Head :title="article.data.title" />
    <div
        class="min-h-screen bg-white text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
    >
        <div class="flex flex-col lg:flex-row">
            <Sidebar />

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div class="mx-auto max-w-4xl">
                    <article article="article">
                        <div
                            class="mb-8 aspect-video overflow-hidden rounded-lg shadow-sm"
                        >
                            <img
                                :src="article.data.cover"
                                :alt="article.data.title"
                                class="h-full w-full object-cover"
                            />
                        </div>

                        <div class="mb-8">
                            <h2 class="mb-4 text-4xl font-bold">
                                {{ article.data.title }}
                            </h2>
                            <ul
                                class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400"
                            >
                                <li class="author">
                                    {{ article.data.author }}
                                </li>
                                <li
                                    class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"
                                ></li>
                                <li class="time">
                                    {{ article.data.details.date }}
                                </li>
                                <li
                                    class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"
                                ></li>
                                <li class="categories">
                                    <span
                                        class="rounded bg-gray-100 px-2 py-1 text-xs font-semibold tracking-wider uppercase dark:bg-gray-800"
                                        >{{
                                            article.data.details.category
                                        }}</span
                                    >
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-12">
                            <!-- Romanian Content -->
                            <div
                                v-if="article.data.details.content_ro"
                                class="prose dark:prose-invert max-w-none"
                            >
                                <p
                                    class="lead mb-4 text-lg font-bold text-gray-600 dark:text-gray-400"
                                >
                                    [RO]
                                </p>
                                <div
                                    class="space-y-6 text-lg leading-relaxed"
                                    v-html="article.data.details.content_ro"
                                ></div>
                            </div>

                            <!-- Images from Article (if any) -->
                            <div
                                v-if="
                                    article.data.details.images &&
                                    article.data.details.images.length > 0
                                "
                                class="my-12 grid grid-cols-1 gap-8"
                            >
                                <img
                                    v-for="(img, idx) in article.data.details
                                        .images"
                                    :key="idx"
                                    :src="img"
                                    class="w-full rounded-lg shadow-sm"
                                    alt=""
                                />
                            </div>

                            <!-- English Content -->
                            <div
                                v-if="article.data.details.content_en"
                                class="prose dark:prose-invert max-w-none pb-12"
                            >
                                <p
                                    class="lead mb-4 text-lg font-bold text-gray-600 dark:text-gray-400"
                                >
                                    [EN]
                                </p>
                                <div
                                    class="space-y-6 text-lg leading-relaxed"
                                    v-html="article.data.details.content_en"
                                ></div>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
</template>
