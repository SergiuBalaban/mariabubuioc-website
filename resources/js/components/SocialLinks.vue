<script setup lang="ts">
import { computed } from 'vue';

const currentYear = computed(() => new Date().getFullYear());
</script>

<template>
    <div class="mt-8 pt-8 border-t border-[#19140015] dark:border-[#3E3E3A]">
        <div class="flex gap-4 mb-4">
            <a
                href="https://ro.linkedin.com/in/maria-bubuioc-51552b40"
                target="_blank"
                class="text-gray-600 transition-colors hover:text-black dark:text-gray-400 dark:hover:text-white"
            >
                <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a
                href="https://www.facebook.com/mbubuioc"
                target="_blank"
                class="text-gray-600 transition-colors hover:text-black dark:text-gray-400 dark:hover:text-white"
            >
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a
                href="https://www.instagram.com/mariacrochet/"
                target="_blank"
                class="text-gray-600 transition-colors hover:text-black dark:text-gray-400 dark:hover:text-white"
            >
                <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
        </div>
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-500">
                mariabubuioc.com &copy; {{ currentYear }} build by
                <a href="https://www.linkedin.com/in/sergiu-balaban-1ba17894/" target="_blank" class="hover:underline">Sergiu Balaban</a>
            </p>
        </div>
    </div>
</template>
