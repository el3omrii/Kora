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
                                Translations
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Automatic Translations, may contain errors, hence the edit button
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
                    <table-lite
                                :has-checkbox="true"
                                checked-return-type="key"
                                @return-checked-rows="checkRow"
                                :columns="tableColumns" 
                                :rows="translations" 
                                :total="totalTranslations"
                                :page-size="perPage"
                                :page.sync="currentPage"
                                @get-now-page="getCurrentPage"
                                @do-search="fetchTranslations"
                                :is-slot-mode="true"
                                :sortable="{order: 'created_at', sort:'desc'}"
                                class="text-sm">

                        <template v-slot:value="data">
                            <div class="flex items-center gap-4" v-if="editing[data.value.key]">
                                <input @keydown.enter="saveTranslation(data.value)" v-model="data.value.value" type="text" class="text-base py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500" />
                                    <div class="flex gap-2">
                                    <button @click="toggleEditing(data.value.key)" class="h-2/3 bg-gray-200 hover:bg-gray-400 text-gray-900 font-bold p-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>

                                </button>
                                <button @click="saveTranslation(data.value)" class="h-2/3 bg-gray-200 hover:bg-gray-400 text-gray-900 font-bold p-2 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </button>
                                </div>
                            </div>
                            <span v-else>{{ data.value.value }}</span>
                        </template>
                        <template v-slot:created_at="data">
                            {{ DateTime.fromISO(data.value.created_at).toRelative() }}
                        </template>
                        <template v-slot:actions="data">
                            <div class="flex item-center justify-center">
                                <button @click="toggleEditing(data.value.key)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'Edit'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                                <div @click="deleteTranslation(data.value.key)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'Delete'">
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
import useTranslations from './useTranslations'
import { DateTime } from 'luxon'

const {
    fetchTranslations,
    saveTranslation,
    deleteTranslation,
    deleteSelected,
    translations,
    checkedRows,
    tableColumns,
    perPage,
    currentPage,
    searchQuery,
    totalTranslations,
    editing,
    toggleEditing,
    getCurrentPage,
    checkRow,
} = useTranslations()

onMounted(()=>{
    fetchTranslations()
})
</script>