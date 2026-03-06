<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, X } from 'lucide-vue-next';
import { ref, computed } from 'vue';

import { Dialog, DialogContent } from '@/components/ui/dialog';

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
                [key: string]: any;
            };
            images: string[];
            price: string | null;
        };
    };
}>();

const selectedImageIndex = ref<number | null>(null);

const allImages = computed(() => {
    const images = [];
    if (props.project.data.cover) {
        images.push(props.project.data.cover);
    }
    if (props.project.data.images) {
        images.push(...props.project.data.images);
    }
    return images;
});

const openLightbox = (index: number) => {
    selectedImageIndex.value = index;
};

const closeLightbox = () => {
    selectedImageIndex.value = null;
};

const nextImage = () => {
    if (selectedImageIndex.value !== null) {
        selectedImageIndex.value = (selectedImageIndex.value + 1) % allImages.value.length;
    }
};

const prevImage = () => {
    if (selectedImageIndex.value !== null) {
        selectedImageIndex.value = (selectedImageIndex.value - 1 + allImages.value.length) % allImages.value.length;
    }
};
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
                    <div v-if="props.project.data.cover" class="mb-12">
                        <img
                            :src="props.project.data.cover"
                            :alt="props.project.data.title"
                            class="w-full cursor-pointer rounded-lg shadow-sm transition-opacity hover:opacity-90"
                            @click="openLightbox(0)"
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
                            <div class="space-y-12">
                                <div
                                    v-if="props.project.data.content"
                                    class="dark:prose-invert prose max-w-none"
                                    v-html="props.project.data.content"
                                ></div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div
                                class="rounded-lg border border-[#19140015] bg-gray-50 p-6 dark:border-[#3E3E3A] dark:bg-[#161615]"
                            >
                                <dl class="space-y-4">
                                    <div
                                        v-for="(value, label) in props.project
                                            .data.details"
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
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="
                            props.project.data.images &&
                            props.project.data.images.length
                        "
                        class="mt-16 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                    >
                        <div
                            v-for="(img, idx) in props.project.data.images"
                            :key="idx"
                            class="aspect-square cursor-pointer overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800"
                            @click="openLightbox(props.project.data.cover ? idx + 1 : idx)"
                        >
                            <img
                                :src="img"
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                                alt=""
                            />
                        </div>
                    </div>

                    <Dialog :open="selectedImageIndex !== null" @update:open="closeLightbox">
                        <DialogContent class="max-w-5xl border-none bg-transparent p-0 shadow-none sm:max-w-5xl">
                            <div class="relative flex h-[85vh] w-full items-center justify-center">
                                <button
                                    @click="prevImage"
                                    class="absolute left-4 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-black/50 text-white transition-colors hover:bg-black/70"
                                >
                                    <ChevronLeft class="h-8 w-8" />
                                </button>

                                <img
                                    v-if="selectedImageIndex !== null"
                                    :src="allImages[selectedImageIndex]"
                                    class="max-h-full max-w-full object-contain shadow-2xl"
                                    alt="Project Image"
                                />

                                <button
                                    @click="nextImage"
                                    class="absolute right-4 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-black/50 text-white transition-colors hover:bg-black/70"
                                >
                                    <ChevronRight class="h-8 w-8" />
                                </button>

                                <button
                                    @click="closeLightbox"
                                    class="absolute top-4 right-4 z-50 flex h-10 w-10 items-center justify-center rounded-full bg-black/50 text-white transition-colors hover:bg-black/70"
                                >
                                    <X class="h-6 w-6" />
                                </button>

                                <div class="absolute bottom-4 left-0 right-0 text-center text-white text-sm font-medium drop-shadow-md">
                                    {{ (selectedImageIndex ?? 0) + 1 }} / {{ allImages.length }}
                                </div>
                            </div>
                        </DialogContent>
                    </Dialog>
                </div>
            </main>
        </div>
    </div>
</template>
