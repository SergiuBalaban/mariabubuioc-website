<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import logoPic from '@/assets/images/logo.png';
import SocialLinks from '@/components/SocialLinks.vue';
import { about, blog } from '@/routes';
import { page as homePage } from '@/routes/home';
</script>

<template>
    <aside
        id="sidebar"
        class="w-full border-b border-[#19140015] p-6 lg:w-64 lg:border-r lg:border-b-0 dark:border-[#3E3E3A]"
    >
        <div class="sticky top-6">
            <h2 class="mb-4 text-xl font-bold">Maria Bubuioc</h2>
<!--            <img :src="logoPic" alt="logo" />-->
            <nav class="space-y-2">
                <Link :href="homePage().url" class="block font-bold"
                    >Works</Link
                >
                <Link :href="about().url" class="block hover:underline"
                    >About</Link
                >
                <Link :href="blog().url" class="block hover:underline"
                    >Blog</Link
                >
            </nav>
            <SocialLinks />
        </div>
    </aside>
</template>
