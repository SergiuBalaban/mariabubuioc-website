<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Sidebar from './Sidebar.vue';

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
    };
}>();

const { images, Shop, ShopUrl, ...otherDetails } =
    props.project.data.details || {};
const detailsToShow = { ...otherDetails };
if (props.project.data.price) {
    detailsToShow.Price = props.project.data.price;
}
</script>

<template>
    <Head :title="props.project.data.title" />
    <div
        class="min-h-screen bg-white text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
    >
        <div class="flex flex-col lg:flex-row">
            <Sidebar />

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div class="mx-auto max-w-5xl">
                    <div class="mb-12">
                        <img
                            :src="props.project.data.cover"
                            :alt="props.project.data.title"
                            class="w-full rounded-lg shadow-sm"
                        />
                    </div>

                    <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                        <div class="space-y-6 lg:col-span-2">
                            <h1 class="text-4xl font-bold">
                                {{ props.project.data.title }}
                            </h1>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm dark:bg-gray-800"
                                    >{{
                                        props.project.data.category_name
                                    }}</span
                                >
                            </div>
                            <div
                                class="text-lg leading-relaxed whitespace-pre-line text-gray-700 dark:text-gray-300"
                            >
                                {{ props.project.data.content }}
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div
                                class="rounded-lg border border-[#19140015] bg-gray-50 p-6 dark:border-[#3E3E3A] dark:bg-[#161615]"
                            >
                                <h3
                                    class="mb-4 text-lg font-bold tracking-wider uppercase"
                                >
                                    Details
                                </h3>
                                <dl class="space-y-4">
                                    <div
                                        v-for="(value, label) in detailsToShow"
                                        :key="label"
                                    >
                                        <dt
                                            class="text-xs font-bold text-gray-500 uppercase dark:text-gray-400"
                                        >
                                            {{ label }}
                                        </dt>
                                        <dd class="text-sm">
                                            <span v-html="value"></span>
                                        </dd>
                                    </div>
                                    <div v-if="Shop">
                                        <dt
                                            class="text-xs font-bold text-gray-500 uppercase dark:text-gray-400"
                                        >
                                            Shop
                                        </dt>
                                        <dd class="text-sm">
                                            <a
                                                v-if="ShopUrl"
                                                :href="ShopUrl"
                                                target="_blank"
                                                class="text-blue-600 hover:underline"
                                                >{{ Shop }}</a
                                            >
                                            <span v-else>{{ Shop }}</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="images && images.length"
                        class="mt-16 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                    >
                        <div
                            v-for="(img, idx) in images"
                            :key="idx"
                            class="aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800"
                        >
                            <img
                                :src="img"
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                                alt=""
                            />
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
