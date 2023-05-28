<template>
    <!-- Card -->
    <div class="flex flex-col font-cairo">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <form @submit.prevent="submit">
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                        <!-- Header -->
                        <div
                            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <h2 v-if="editMode" class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    Edit Post
                                </h2>
                                <h2 v-else class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    New Post
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ post.title }}
                                </p>
                            </div>

                            <div>
                                <div class="flex gap-4">
                                    <button type="submit"
                                        class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        Save Post
                                    </button>
                                    <a href="/posts" role="button"
                                        class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- New Article-->
                        <div class="flex sm:flex-col md:flex-row gap-4 p-4 divide-x">
                            <div class="w-full">
                                <div>
                                    <label for="title">Post title</label>
                                    <input @keyup="post.slug = slugify(post.title)" type="text" id="title"
                                        v-model="post.title"
                                        class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"
                                        placeholder="Enter title" required focus>
                                    <span v-if="errors && errors.title" class="text-sm text-red-500">{{ errors.title[0]
                                    }}</span>
                                </div>
                                <div class="mt-2">
                                    <label for="slug">Post Slug</label>
                                    <input type="text" id="slug" v-model="post.slug"
                                        class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"
                                        placeholder="Enter slug" required>
                                    <span v-if="errors && errors.slug" class="text-sm text-red-500">{{ errors.slug[0]
                                    }}</span>
                                </div>
                                <div v-if="post.source_link" class="mt-2">
                                    <label for="link">Post from source</label>
                                    <input disabled type="text" id="link" v-model="post.source_link"
                                        class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500">
                                </div>
                                <div class="mt-2 h-full">
                                    <label>Post Content</label>
                                    <CKEditor.component :editor="ClassicEditor" :config="config" v-model="post.content">
                                    </CKEditor.component>
                                </div>
                            </div>
                            <div class="sm:w-full md:w-2/6 p-4">
                                <div class="mb-4">
                                    <SwitchGroup>
                                        <div class="flex items-center justify-between">
                                            <SwitchLabel class="mr-4 font-bold text-lg">Featured ?</SwitchLabel>
                                            <Switch v-model="post.featured"
                                                :class='post.featured ? "bg-blue-600" : "bg-gray-200"'
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                                <span :class='post.featured ? "translate-x-6" : "translate-x-1"'
                                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform" />
                                            </Switch>
                                        </div>
                                    </SwitchGroup>
                                </div>
                                <div class="relative">
                                    <label>Post Image</label>
                                    <img v-if="imagePreview" :src="imagePreview" id="image"
                                        class="shadow-lg rounded-md w-full h-auto" />
                                    <img v-else :src="defaultImage" id="image" class="shadow-lg rounded-md w-full h-auto" />
                                    <div v-if="imagePreview" @click="resetImage"
                                        class="absolute top-8 right-2 p-1 w-auto rounded-md cursor-pointer bg-gray-400 opacity-50 text-red-500 transition-all duration-300 ease-out hover:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block">
                                            <span class="sr-only">Choose File</span>
                                            <input @change="onFileChange" type="file" name="source_image"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </label>
                                    </div>
                                    <div v-if="post.categories" class="mt-2">
                                        <label>Post Category</label>
                                        <div class="flex flex-wrap gap-4 mt-2">
                                            <v-checkbox v-for="category in categories" :category="category"
                                                :checked="post.categories" @category-selected="updateCategories">
                                            </v-checkbox>
                                        </div>
                                        <span v-if="errors && errors.categories" class="text-sm text-red-500">{{
                                            errors.categories[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Card -->
</template>

<script setup>
import CKEditor from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import useNewPost from './useNewPost'
import VCheckbox from '../v-checkbox.vue'
import { onMounted } from 'vue';
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

const props = defineProps({
    postId: Number
})

const config = {
    language: {
        ui: 'en',
        content: 'ar'
    }
}

const {
    slugify,
    onFileChange,
    resetImage,
    imagePreview,
    defaultImage,
    post,
    categories,
    errors,
    editMode,
    updateCategories,
    submit
} = useNewPost()
//init
onMounted(() => {
    if (props.postId) {
        editMode.value = true
        axios.get(`/posts/edit/${props.postId}`)
            .then(response => {
                post.value = response.data
                defaultImage.value = post.value.image
            })
    }
    axios.get(`/posts/categories`)
        .then((response) => categories.value = response.data)
})
</script>
<style>.ck-editor__editable_inline {
    min-height: 340px;
}</style>