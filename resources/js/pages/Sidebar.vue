<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import SocialLinks from '@/components/SocialLinks.vue';
import { about, blog } from '@/routes';
import { page as homePage } from '@/routes/home';
</script>

<template>
  <aside
    id="sidebar"
    class="w-full lg:w-64 p-6 border-b lg:border-b-0 lg:border-r border-[#19140015] dark:border-[#3E3E3A]"
  >
    <div class="sticky top-6">
      <h2 class="text-xl font-bold mb-4">Maria Bubuioc</h2>
      <nav class="space-y-2">
        <Link :href="homePage().url" class="block font-bold">Works</Link>
        <Link :href="about().url" class="block hover:underline">About</Link>
        <Link :href="blog().url" class="block hover:underline">Blog</Link>
      </nav>
      <SocialLinks />
    </div>
  </aside>
</template>
