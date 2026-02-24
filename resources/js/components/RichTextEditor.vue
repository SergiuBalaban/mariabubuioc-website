<script setup lang="ts">
import { Image as TiptapImage } from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import axios from 'axios';
import {
    Bold,
    Code,
    Eye,
    FileCode,
    Heading1,
    Heading2,
    Heading3,
    Heading4,
    Heading5,
    Image as ImageIcon,
    Italic,
    Link as LinkIcon,
    List,
    ListOrdered,
    Quote,
    Redo,
    Strikethrough,
    Undo,
} from 'lucide-vue-next';
import { onBeforeUnmount, ref, watch } from 'vue';

const props = defineProps<{
    modelValue: string | any;
}>();

const emit = defineEmits(['update:modelValue']);

const isHtmlView = ref(false);
const rawHtml = ref('');
const fileInput = ref<HTMLInputElement | null>(null);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        Link.configure({
            openOnClick: false,
        }),
        TiptapImage,
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
            editor.value.commands.setContent(newValue);
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

const setLink = () => {
    const url = window.prompt('URL:');
    if (url === null) {
        return;
    }

    if (url === '') {
        editor.value?.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
    }

    editor.value
        ?.chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run();
};

const triggerImageUpload = () => {
    fileInput.value?.click();
};

const handleImageUpload = async (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('cover', file);

    try {
        const response = await axios.post(
            '/admin/blogs/upload-cover',
            formData,
            {
                headers: { 'Content-Type': 'multipart/form-data' },
            },
        );

        const url = response.data.path;
        if (editor.value) {
            editor.value.chain().focus().setImage({ src: url }).run();
        }
    } catch (error) {
        console.error('Image upload failed:', error);
    } finally {
        target.value = '';
    }
};

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div
        class="overflow-hidden rounded-xl border border-sidebar-border/70 bg-white dark:border-sidebar-border dark:bg-gray-900"
    >
        <!-- Toolbar -->
        <div
            v-if="editor"
            class="flex flex-wrap items-center gap-1 border-b border-sidebar-border/70 bg-sidebar-accent/50 p-2 dark:border-sidebar-border"
        >
            <template v-if="!isHtmlView">
                <div class="flex flex-wrap items-center gap-1">
                    <button
                        type="button"
                        @click="editor.chain().focus().undo().run()"
                        :disabled="!editor.can().undo()"
                        class="rounded p-2 hover:bg-gray-200 disabled:opacity-30 dark:hover:bg-gray-700"
                        title="Undo"
                    >
                        <Undo class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="editor.chain().focus().redo().run()"
                        :disabled="!editor.can().redo()"
                        class="rounded p-2 hover:bg-gray-200 disabled:opacity-30 dark:hover:bg-gray-700"
                        title="Redo"
                    >
                        <Redo class="h-4 w-4" />
                    </button>
                    <div
                        class="mx-1 h-6 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>

                    <button
                        type="button"
                        @click="editor.chain().focus().toggleBold().run()"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('bold'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Bold"
                    >
                        <Bold class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleItalic().run()"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('italic'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Italic"
                    >
                        <Italic class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleStrike().run()"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('strike'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Strike"
                    >
                        <Strikethrough class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleCode().run()"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('code'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Code"
                    >
                        <Code class="h-4 w-4" />
                    </button>

                    <div
                        class="mx-1 h-6 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>

                    <button
                        type="button"
                        @click="
                            editor
                                .chain()
                                .focus()
                                .toggleHeading({ level: 1 })
                                .run()
                        "
                        :class="{
                            'bg-gray-200 dark:bg-gray-700': editor.isActive(
                                'heading',
                                { level: 1 },
                            ),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Heading 1"
                    >
                        <Heading1 class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="
                            editor
                                .chain()
                                .focus()
                                .toggleHeading({ level: 2 })
                                .run()
                        "
                        :class="{
                            'bg-gray-200 dark:bg-gray-700': editor.isActive(
                                'heading',
                                { level: 2 },
                            ),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Heading 2"
                    >
                        <Heading2 class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="
                            editor
                                .chain()
                                .focus()
                                .toggleHeading({ level: 3 })
                                .run()
                        "
                        :class="{
                            'bg-gray-200 dark:bg-gray-700': editor.isActive(
                                'heading',
                                { level: 3 },
                            ),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Heading 3"
                    >
                        <Heading3 class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="
                            editor
                                .chain()
                                .focus()
                                .toggleHeading({ level: 4 })
                                .run()
                        "
                        :class="{
                            'bg-gray-200 dark:bg-gray-700': editor.isActive(
                                'heading',
                                { level: 4 },
                            ),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Heading 4"
                    >
                        <Heading4 class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="
                            editor
                                .chain()
                                .focus()
                                .toggleHeading({ level: 5 })
                                .run()
                        "
                        :class="{
                            'bg-gray-200 dark:bg-gray-700': editor.isActive(
                                'heading',
                                { level: 5 },
                            ),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Heading 5"
                    >
                        <Heading5 class="h-4 w-4" />
                    </button>

                    <div
                        class="mx-1 h-6 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>

                    <button
                        type="button"
                        @click="editor.chain().focus().toggleBulletList().run()"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('bulletList'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Bullet List"
                    >
                        <List class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="
                            editor.chain().focus().toggleOrderedList().run()
                        "
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('orderedList'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Ordered List"
                    >
                        <ListOrdered class="h-4 w-4" />
                    </button>
                    <button
                        type="button"
                        @click="editor.chain().focus().toggleBlockquote().run()"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('blockquote'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Quote"
                    >
                        <Quote class="h-4 w-4" />
                    </button>

                    <div
                        class="mx-1 h-6 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>

                    <button
                        type="button"
                        @click="setLink"
                        :class="{
                            'bg-gray-200 dark:bg-gray-700':
                                editor.isActive('link'),
                        }"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Link"
                    >
                        <LinkIcon class="h-4 w-4" />
                    </button>

                    <button
                        type="button"
                        @click="triggerImageUpload"
                        class="rounded p-2 hover:bg-gray-200 dark:hover:bg-gray-700"
                        title="Upload Image"
                    >
                        <ImageIcon class="h-4 w-4" />
                    </button>
                    <input
                        type="file"
                        ref="fileInput"
                        class="hidden"
                        accept="image/*"
                        @change="handleImageUpload"
                    />
                </div>
            </template>

            <div class="flex-1"></div>

            <button
                type="button"
                @click="toggleHtmlView"
                class="flex items-center gap-1.5 rounded px-3 py-1.5 text-xs font-medium tracking-wider uppercase transition-colors"
                :class="
                    isHtmlView
                        ? 'bg-primary text-primary-foreground'
                        : 'text-gray-700 hover:bg-gray-200 dark:text-gray-300 dark:hover:bg-gray-700'
                "
                :title="
                    isHtmlView ? 'Switch to Visual View' : 'Switch to HTML View'
                "
            >
                <component
                    :is="isHtmlView ? Eye : FileCode"
                    class="h-3.5 w-3.5"
                />
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
                class="h-75 w-full resize-none bg-transparent p-4 font-mono text-sm focus:outline-none"
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
