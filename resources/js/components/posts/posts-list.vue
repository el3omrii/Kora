<template>
    <!-- Card -->
    <div class="flex flex-col font-cairo">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div
                        class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Articles
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Articles scraped from
                            </p>
                        </div>

                        <div>
                            <div class="flex gap-4">
                                <div class="sm:col-span-1">
                                      <div class="relative">
                                        <input type="text" v-model="searchQuery" class="text-base pl-10 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500" placeholder="Search">
                                        <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                                          <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                          </svg>
                                        </div>
                                      </div>
                                    </div>
                                <a href="/posts/new" role="button"
                                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    New Post
                                </a>
                                <button @click="deleteSelected" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                Delete selected ({{ checkedRows.length }})
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table-lite :ref="refPostListTable"
                                :has-checkbox="true"
                                checked-return-type="key"
                                @return-checked-rows="checkRow"
                                :columns="tableColumns" 
                                :rows="posts" 
                                :total="totalPosts"
                                :page-size="perPage"
                                :page.sync="currentPage"
                                @get-now-page="getCurrentPage"
                                @do-search="fetchPosts"
                                :is-slot-mode="true"
                                class="text-sm">
                        <template v-slot:image="data">
                            <img :src="data.value.image" class="rounded-md w-20 h-auto" />
                        </template>
                        <template v-slot:title="data">
                            <a :href="`/posts/edit/${data.value.id}`">{{ data.value.title }}</a>
                        </template>
                        <template v-slot:category="data">
                            <div class="flex flex-wrap">
                                <span class="inline-flex items-center py-0.5 px-2 rounded-md cursor-pointer text-xs font-medium hover:bg-purple-600 hover:text-white bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    {{ data.value.category.name }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                </svg>
                            </span>
                        </div>
                        </template>
                        <template v-slot:created_at="data">
                            {{ DateTime.fromISO(data.value.created_at).toRelative() }}
                        </template>
                        <template v-slot:status="data">
                            <span v-if="data.value.status === 'published'" class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                </svg>
                                Published
                            </span>
                            <span v-if="data.status === 'unpublished'" class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
                                </svg>
                                Rejected
                            </span>
                            <span>
                                <SwitchGroup @click="setFeatured(data.value.id)">
                                <div class="flex items-center mt-2">
                                    <SwitchLabel class="mr-2 text-sm">Featured</SwitchLabel>
                                    <Switch v-model="data.value.featured" :class='data.value.featured ? "bg-blue-600" : "bg-gray-200"'
                                    class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors">
                                    <span :class='data.value.featured ? "translate-x-4" : "translate-x-1"'
                                        class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform" />
                                    </Switch>
                                </div>
                                </SwitchGroup>
                            </span>
                        </template>
                        <template v-slot:actions="data">
                            <div class="flex item-center justify-center">
                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'View'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </div>
                                <a :href="`/posts/edit/${data.value.id}`" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'Edit'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                                <div @click="deletePost(data.value.id)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'Delete'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </template>

                    </table-lite>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</template>

<script setup>
import { onMounted } from 'vue'
import TableLite from "vue3-table-lite"
import usePostsList from './usePostsList'
import { DateTime } from 'luxon'
import { Switch, SwitchLabel, SwitchGroup } from '@headlessui/vue'
const {
    fetchPosts,
    deletePost,
    deleteSelected,
    setFeatured,
    posts,
    checkedRows,
    tableColumns,
    perPage,
    currentPage,
    searchQuery,
    totalPosts,
    refPostListTable,
    getCurrentPage,
    checkRow,
} = usePostsList()
onMounted(()=>{
    fetchPosts()
})
</script>