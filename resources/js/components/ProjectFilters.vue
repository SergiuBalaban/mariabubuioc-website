<script setup lang="ts">
const props = defineProps<{
    activeFilter: string;
    categories: Array<{ label: string; value: string }>;
}>();

const emit = defineEmits<{
    filterChange: [filter: string];
}>();

const handleFilterClick = (filterValue: string) => {
    emit('filterChange', filterValue);
};
</script>

<template>
    <div class="widgets-block mb-6">
        <div class="widget filter">
            <p class="title mb-4 text-lg font-semibold">Works Filter</p>
            <ul class="space-y-2">
                <li
                    v-for="filter in categories"
                    :key="filter.value"
                    :class="{ 'active font-bold': activeFilter === filter.value }"
                    class="cursor-pointer hover:underline"
                    @click="handleFilterClick(filter.value)"
                >
                    {{ filter.label }}
                </li>
            </ul>
        </div>
    </div>
</template>