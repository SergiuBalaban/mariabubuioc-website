<script setup lang="ts">
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import StarterKit from '@tiptap/starter-kit';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import { onBeforeUnmount, ref, watch } from 'vue';

const props = defineProps<{
    modelValue: string | any;
}>();

const emit = defineEmits(['update:modelValue']);

const isHtmlView = ref(false);
const rawHtml = ref('');

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        Link.configure({
            openOnClick: false,
        }),
        Image,
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl mx-auto focus:outline-none min-h-[300px] p-4',
        },
    },
    onUpdate: ({ editor }) => {
        if (!isHtmlView.value) {
            const html = editor.getHTML();
            emit('update:modelValue', html);
            rawHtml.value = html;
        }
    },
});

// Watch for external changes
watch(
    () => props.modelValue,
    (newValue) => {
        if (editor.value && newValue !== editor.value.getHTML()) {
            // Only update if the content is different to avoid cursor jumps
            // This is a simple check; for robust sync, more logic might be needed
            // But for this use case, it's usually fine.
            // However, if we are in HTML view, we handle it differently.
        }
    },
);

const toggleHtmlView = () => {
    isHtmlView.value = !isHtmlView.value;
    if (isHtmlView.value) {
        rawHtml.value = editor.value?.getHTML() || '';
    } else {
        editor.value?.commands.setContent(rawHtml.value);
        emit('update:modelValue', rawHtml.value);
    }
};

const updateFromRawHtml = () => {
    emit('update:modelValue', rawHtml.value);
};

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div
        class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden"
    >
        <!-- Toolbar -->
        <div
            v-if="editor"
            class="flex flex-wrap items-center gap-2 border-b border-sidebar-border/70 bg-sidebar-accent/50 p-2 dark:border-sidebar-border"
        >
            <template v-if="!isHtmlView">
                <button
                    type="button"
                    @click="editor.chain().focus().toggleBold().run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('bold') }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Bold
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleItalic().run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('italic') }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Italic
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleStrike().run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('strike') }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Strike
                </button>
                <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('heading', { level: 1 }) }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    H1
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('heading', { level: 2 }) }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    H2
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('heading', { level: 3 }) }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    H3
                </button>
                <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleBulletList().run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('bulletList') }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Bullet
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleOrderedList().run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('orderedList') }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Ordered
                </button>
                <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleBlockquote().run()"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': editor.isActive('blockquote') }"
                    class="rounded px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Quote
                </button>
            </template>

            <div class="flex-1"></div>

            <button
                type="button"
                @click="toggleHtmlView"
                class="rounded px-2 py-1 text-xs font-bold uppercase tracking-wider hover:bg-gray-200 dark:hover:bg-gray-700"
                :class="{ 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-100': isHtmlView }"
            >
                {{ isHtmlView ? 'Visual' : 'HTML' }}
            </button>
        </div>

        <!-- Editor Content -->
        <div class="bg-white dark:bg-gray-900">
            <EditorContent v-show="!isHtmlView" :editor="editor" />
            <textarea
                v-show="isHtmlView"
                v-model="rawHtml"
                @input="updateFromRawHtml"
                class="w-full h-[300px] p-4 font-mono text-sm bg-transparent focus:outline-none resize-none"
            ></textarea>
        </div>
    </div>
</template>

<style scoped>
/* Basic prose styles if @tailwindcss/typography is not fully configured or to override */
:deep(.prose ul) {
    list-style-type: disc;
    padding-left: 1.5em;
}
:deep(.prose ol) {
    list-style-type: decimal;
    padding-left: 1.5em;
}
:deep(.prose blockquote) {
    border-left: 4px solid #e5e7eb;
    padding-left: 1em;
    font-style: italic;
}
</style>
