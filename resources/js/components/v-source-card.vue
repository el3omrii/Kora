<template>
   
<div class="w-full max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="h-full flex flex-col justify-between items-center py-6">
        <img class="w-48 h-auto mb-3 rounded-md shadow-lg" :src="logo" alt="source logo"/>
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><slot name="title"></slot></h5>
        <span class="text-sm text-gray-500 dark:text-gray-400"><slot name="content"></slot></span>
        <div class="relative bottom-0 flex mt-4 space-x-3 md:mt-6">
          <button title="edit" @click="edit(id)" class="flex p-2 rounded-md text-white bg-indigo-400 text-xs uppercase hover:bg-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
     </button>
     <button title="delete" @click="showConfirmModal = true" class="flex p-2 rounded-md text-white bg-indigo-400 text-xs uppercase hover:bg-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
      </button>
            <a :href="'/sources/scraper/' + id" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Scrape
        <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </a>
        </div>
    </div>
    <v-modal v-if="showConfirmModal" type="danger" title="Delete source" width="sm" @close="showEditModal = false">
        <p class="text-gray-800">
      Are you sure you want you delete this source? This action cannot be undone.
    </p>

    <div class="text-right mt-4">
      <button @click="showConfirmModal = false" class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">Cancel</button>
      <button @click="deleteSource(id)" class="mr-2 px-4 py-2 text-sm rounded text-white bg-red-500 focus:outline-none hover:bg-red-400">Delete</button>
    </div>
    </v-modal>
</div>
</template>
<script setup>
import { ref } from 'vue';

defineProps({
    logo: String,
    id: Number,
})

const showConfirmModal = ref(false)

const deleteSource = (id) => {
    axios.post(`/sources/${id}`, {
        "_method": "DELETE"
    }).then(() => window.location.href="/sources")
    .catch(() => window.location.href="/sources") 
}

const edit = (id) => {
  window.location.href=`/sources/?edit=${id}`
}
</script>