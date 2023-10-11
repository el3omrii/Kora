<template>
  <!-- Card -->
  <div class="flex flex-col font-cairo">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
          <!-- Header -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
            <div>
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Articles
              </h2>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Articles scraped from {{ source.name }}
              </p>
            </div>

            <div>
              <div>
                <button @click="publishSelected" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                    </svg>
                  Publish selected ({{ selected }})
                </button>
              </div>
            </div>
          </div>
          <!-- End Header -->

          <!-- Table -->
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:text-gray-200">
            <thead class="bg-gray-50 dark:bg-slate-800">
              <tr>
                <th scope="col" class="w-8 py-3 text-center">
                  <label for="checkall">
                    <input @click="checkAll" type="checkbox" class="shrink-0 border-gray-200 rounded text-blue-600 pointer-events-none focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="checkall">
                    <span class="sr-only">Checkbox</span>
                  </label>
                </th>

                <th scope="col" class="w-24 pl-6 lg:pl-3 xl:pl-0 pr-6 py-3 text-center">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      Image
                    </span>
                  </div>
                </th>

                <th scope="col" class="w1/4 px-6 py-3 text-center">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      Title
                    </span>
                  </div>
                </th>

                <th scope="col" class="w1/4 px-6 py-3 text-left">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      Description
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-left">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      Pub Date
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-right"></th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              <tr v-for="(item,idx) in items">
                <td class="text-center">
                    <label :for="`check${idx}`">
                      <input v-model="item.checked" type="checkbox" class="shrink-0 border-gray-200 rounded text-blue-600 pointer-events-none focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" :id="`check${idx}`">
                      <span class="sr-only">Checkbox</span>
                    </label>
                </td>
                <td class="text-center">
                      <img class="w-20 h-auto rounded-md" :src="item.image">
                </td>
                <td>
                    {{ item.title }}
                </td>
                <td>
                  <div class="px-6 py-3">
                    {{ item.description }}                    
                  </div>
                </td>
                <td>
                  <div class="px-6 py-3 text-sm">
                    {{ item.pubDate }}
                  </div>
                </td>
                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-1.5">
                    <button @click="publish(idx)"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                        Publish
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- End Table -->

          <!-- Footer -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-gray-700">
            <div>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold text-gray-800 dark:text-gray-200">6</span> results
              </p>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                  <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                  </svg>
                  Prev
                </button>

                <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                  Next
                  <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
  <v-modal v-if="showModal" type="success" title="Manual feed" width="sm" @close="showModal = false">
      <!-- Card -->
      <div class="bg-white border shadow-sm rounded-xl p-4 dark:bg-gray-800 dark:border-gray-700">
        <form action="/sources/scraper/manual" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" :value="csrf" />
          <input type="hidden" name="source_id" :value="source.id" />
          <div class="flex sm:flex-col items-center gap-4">
          <p>Could not load the feed. follow this url and try copy paste. <a :href="source.feed_url" target="_blank">{{ source.feed_url }}</a></p>
              <textarea class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"
                        id="feed" name="feed" rows="10" placeholder="feed content"></textarea>
            </div>
          
          <div class="text-right mt-4">
            <button @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">Cancel</button>
            <button type="submit" class="mr-2 px-4 py-2 text-sm rounded text-white bg-teal-500 focus:outline-none hover:bg-teal-400">Add</button>
          </div>
        </form>
      </div>
      <!-- End Card -->
    </v-modal>
  <!-- End Card -->
</template>

<script setup>
import { computed } from '@vue/reactivity';
import { onMounted, ref, inject } from 'vue';
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css'

const items = ref([])
const props = defineProps({
    source: Object
})
const showModal = ref(false)
const csrf = ref()
onMounted(() => {
    csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    axios.get(`/sources/scraper/${props.source.id}/entries`)
        .then((response) => {
            items.value = response.data
            createToast({
                title: "Success",
                description: "Articles loaded from feed",
            },
            {
                type: "success",
                timeout: 5000,
                showIcon: true,
                position: 'bottom-right',
            })
        })
        .catch((response) => {
          showModal.value = true
        }) 
})
const checkAll = () => {
    items.value.forEach(element => {
        element.checked = !element.checked
    });
}
const selected = computed(()=>{
    return items.value.filter(el => el.checked === true).length
})
const publishSelected = () => {
    items.value.forEach((element, index) => {
        if (element.checked === true) {
            publish(index)
        }
    })
}
const publish = (idx) => {
    axios.post('/sources/scraper/publish', {
        source_id: props.source.id,
        index: idx
    }).then(() => createToast({
                title: "Success",
                description: "Article is now published",
            },
            {
                type: "success",
                timeout: 5000,
                showIcon: true,
                position: 'bottom-right',
            }))
        .catch(() => createToast({
                title: "Error",
                description: "Something went wrong!",
            },
            {
                type: "danger",
                timeout: 5000,
                showIcon: true,
                position: 'bottom-right',
            }))
}
</script>