<template>
  <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 mb-6">
    <h3 class="mb-4 text-xl font-bold">General information</h3>

    <form @submit.prevent="storeSettings">
      <div>
        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Website title</label>
        <input type="text" v-model="settings.website_title" name="title" id="title"
          class="w-3/4 shadow-lg-sm border border-gray-300 text-gray-900 focus:outline-none rounded-md focus:border-indigo-500 p-2.5"
          placeholder="website title" required="">
      </div>
      <div class="mt-4">
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Website Description</label>
        <textarea v-model="settings.website_description" name="description" id="description" rows="5"
          class="w-3/4 shadow-lg-sm border border-gray-300 text-gray-900 focus:outline-none rounded-md focus:border-indigo-500 p-2.5"></textarea>
      </div>
      <div class="mt-4">
        <SwitchGroup>
          <div class="flex items-center">
            <SwitchLabel class="mr-4">Enable CDN</SwitchLabel>
            <Switch v-model="settings.cdn" :class='settings.cdn ? "bg-blue-600" : "bg-gray-200"'
              class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
              <span :class='settings.cdn ? "translate-x-6" : "translate-x-1"'
                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform" />
            </Switch>
          </div>
        </SwitchGroup>
      </div>
      <div class="mt-4" v-if="settings.cdn">
        <label for="cdn_url" class="block mb-2 text-sm font-medium text-gray-900">CDN URL</label>
        <input type="text" v-model="settings.cdn_url" name="title" id="title"
          class="w-3/4 shadow-lg-sm border border-gray-300 text-gray-900 focus:outline-none rounded-md focus:border-indigo-500 p-2.5"
          placeholder="cdn URL" required="">
      </div>
    <div class="mt-8 flex gap-4">
      <button type="submit"
        class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
        </svg>
        Apply
      </button>
      <a href="/settings" role="button"
        class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
        Cancel
      </a>
    </div>
    </form>
  </div>
</template>
<script setup>
import { Switch, SwitchLabel, SwitchGroup } from '@headlessui/vue'
import useSettings from './useSettings'
import { onMounted } from 'vue';

const { settings, fetchSettings, storeSettings } = useSettings()

onMounted(() => {
  fetchSettings()
})
</script>