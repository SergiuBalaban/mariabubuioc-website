<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { about, blog, home } from '@/routes';
import { page as homePage } from '@/routes/home';

const props = defineProps<{
    project: {
        data: {
            id: number;
            title: string;
            category_name: string;
            cover: string;
            content: string;
            details: {
                images?: string[];
                Shop?: string;
                ShopUrl?: string;
                [key: string]: any;
            };
            price: string | null;
        };
    }
}>();

const { images, Shop, ShopUrl, ...otherDetails } = props.project.data.details || {};
const detailsToShow = { ...otherDetails };
if (props.project.data.price) {
    detailsToShow.Price = props.project.data.price;
}
</script>

<template>
    <Head :title="props.project.data.title" />
    <div class="min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
        <div class="flex flex-col lg:flex-row">
            <aside id="sidebar" class="w-full lg:w-64 p-6 border-b lg:border-b-0 lg:border-r border-[#19140015] dark:border-[#3E3E3A]">
                <div class="sticky top-6">
                    <h2 class="text-xl font-bold mb-4">Maria Bubuioc</h2>
                    <nav class="space-y-2">
                        <Link :href="home().url" class="block hover:underline">Welcome</Link>
                        <Link :href="homePage().url" class="block hover:underline">Works</Link>
                        <Link :href="about().url" class="block hover:underline">About</Link>
                        <Link :href="blog().url" class="block hover:underline">Blog</Link>
                    </nav>
                </div>
            </aside>

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div class="max-w-5xl mx-auto">
                    <div class="mb-12">
                        <img :src="props.project.data.cover" :alt="props.project.data.title" class="w-full rounded-lg shadow-sm" />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <div class="lg:col-span-2 space-y-6">
                            <h1 class="text-4xl font-bold">{{ props.project.data.title }}</h1>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-sm">{{ props.project.data.category_name }}</span>
                            </div>
                            <div class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                {{ props.project.data.content }}
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-gray-50 dark:bg-[#161615] p-6 rounded-lg border border-[#19140015] dark:border-[#3E3E3A]">
                                <h3 class="text-lg font-bold mb-4 uppercase tracking-wider">Details</h3>
                                <dl class="space-y-4">
                                    <div v-for="(value, label) in detailsToShow" :key="label">
                                        <dt class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ label }}</dt>
                                        <dd class="text-sm">
                                            <span v-html="value"></span>
                                        </dd>
                                    </div>
                                    <div v-if="Shop">
                                        <dt class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Shop</dt>
                                        <dd class="text-sm">
                                            <a v-if="ShopUrl" :href="ShopUrl" target="_blank" class="text-blue-600 hover:underline">{{ Shop }}</a>
                                            <span v-else>{{ Shop }}</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div v-if="images && images.length" class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="(img, idx) in images" :key="idx" class="aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
                            <img :src="img" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
