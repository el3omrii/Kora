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
                              Matches
                          </h2>
                          <p class="text-sm text-gray-600 dark:text-gray-400">
                              Matches scraped from API
                          </p>
                      </div>

                      <div>
                          <div>
                              <button
                                  class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                      stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                  </svg>
                                  Delete selected ()
                              </button>
                          </div>
                      </div>
                  </div>
                  <!-- End Header -->

                  <!-- Table -->
                  <table-lite 
                              :columns="tableColumns" 
                              :rows="matches" 
                              :total="totalMatches"
                              :page-size="perPage"
                              :page.sync="currentPage"
                              @get-now-page="getCurrentPage"
                              @do-search="fetchMatches"
                              :is-slot-mode="true">
                      <template v-slot:league="data">
                          <img :src="data.value.fixture_data.league.logo" class="rounded-md w-20 h-auto max-h-20 object-contain" />
                      </template>
                      <template v-slot:homeTeam="data">
                          <img :src="data.value.fixture_data.teams.home.logo" class="rounded-md w-20 h-auto" />
                      </template>
                      <template v-slot:date="data">
                          {{ DateTime.fromISO(data.value.fixture_data.fixture.date).toRelative() }}
                      </template>
                      <template v-slot:awayTeam="data">
                          <img :src="data.value.fixture_data.teams.away.logo" class="rounded-md w-20 h-auto" />
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
                      </template>
                      <template v-slot:actions="data">
                          <div class="flex item-center justify-center">
                              <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-title="'View'">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                      stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                      </path>
                                  </svg>
                              </div>
                              <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-title="'Edit'">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                      stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                      </path>
                                  </svg>
                              </div>
                              <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-title="'Delete'">
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
import { onMounted } from 'vue';
import TableLite from "vue3-table-lite";
import useMatchesList from './useMatchesList'
import { DateTime } from 'luxon'

const {
  fetchMatches,
  matches,
  tableColumns,
  perPage,
  currentPage,
  totalMatches,
  perPageOptions,
  searchQuery,
  sortBy,
  isSortDirDesc,
  getCurrentPage,
} = useMatchesList()

onMounted(()=>{
  fetchMatches()
})
</script>