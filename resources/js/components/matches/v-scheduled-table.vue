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
                          <div class="flex flex-col items-center">
                            <img :src="data.value.fixture_data.teams.home.logo" class="rounded-md w-20 h-auto" />
                            <span>{{ data.value.home }}</span>
                          </div>
                      </template>
                      <template v-slot:date="data">
                          {{ DateTime.fromISO(data.value.fixture_data.fixture.date).toRelative() }}
                      </template>
                      <template v-slot:awayTeam="data">
                          <div class="flex flex-col items-center">
                            <img :src="data.value.fixture_data.teams.away.logo" class="rounded-md w-20 h-auto" />
                            <span>{{ data.value.away }}</span>
                          </div>
                      </template>
                      <template v-slot:status="data">
                      {{data.value.fixture_data.fixture.status.long}}
                      </template>
                      <template v-slot:actions="data">
                          <div class="flex item-center justify-center">
                              <div @click="updateMatch(data.value.id)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'Update'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                              </div>
                              <div @click="deleteMatch(data.value.id)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" v-tooltip="'Delete'">
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
  deleteMatch,
  updateMatch,
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