<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Sidebar from './Sidebar.vue';

defineProps<{
    article: {
        data: {
            id: number;
            title: string;
            cover: string;
            content: string;
            created_at: string;
            updated_at: string;
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
                                <li class="time">
                                    {{ article.data.created_at }}
                                </li>
                                <li
                                    class="h-1 w-1 rounded-full bg-gray-300 dark:bg-gray-600"
                                ></li>
                                <li class="categories">
                                    <span
                                        class="rounded bg-gray-100 px-2 py-1 text-xs font-semibold tracking-wider uppercase dark:bg-gray-800"
                                    >Uncategorized</span>
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-12">
                            <div
                                v-if="article.data.content"
                                class="dark:prose-invert prose max-w-none"
                            >
                                <div
                                    class="space-y-6 text-lg leading-relaxed"
                                    v-html="article.data.content"
                                ></div>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
</template>
