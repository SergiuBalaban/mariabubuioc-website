<script setup lang="ts">
import { computed } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faLinkedin, faFacebook, faInstagram } from '@fortawesome/free-brands-svg-icons';

const currentYear = computed(() => new Date().getFullYear());
</script>

<template>
    <div class="mt-8 pt-8 border-t border-[#19140015] dark:border-[#3E3E3A]">
        <div class="flex gap-4 mb-4 justify-center text-center">
            <a
                href="https://ro.linkedin.com/in/maria-bubuioc-51552b40"
                target="_blank"
                class="text-gray-600 transition-colors hover:text-black dark:text-gray-400 dark:hover:text-white"
            >
                <FontAwesomeIcon :icon="faLinkedin" />
            </a>
            <a
                href="https://www.facebook.com/mbubuioc"
                target="_blank"
                class="text-gray-600 transition-colors hover:text-black dark:text-gray-400 dark:hover:text-white"
            >
                <FontAwesomeIcon :icon="faFacebook" />
            </a>
            <a
                href="https://www.instagram.com/mariacrochet/"
                target="_blank"
                class="text-gray-600 transition-colors hover:text-black dark:text-gray-400 dark:hover:text-white"
            >
                <FontAwesomeIcon :icon="faInstagram" />
            </a>
        </div>
        <div>
            <p class="text-xs">
                mariabubuioc.com &copy; {{ currentYear }} build by
                <a href="https://www.linkedin.com/in/sergiu-balaban-1ba17894/" target="_blank" class="hover:underline">Sergiu Balaban</a>
            </p>
        </div>
    </div>
</template>
