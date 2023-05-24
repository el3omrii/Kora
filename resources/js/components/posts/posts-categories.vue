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
                  Categories
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                  List of categories
                </p>
              </div>
  
              <div>
                <div class="flex gap-4">
                    <button @click="newCat" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                   New Category
                  </button>
                  <button @click="deleteSelected" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                   Delete selected ({{ selected }})
                  </button>
                </div>
              </div>
            </div>
            <!-- End Header -->
  
            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                  <th scope="col" class="w-24 py-3 text-center">
                    <label for="checkall">
                      <input @click="checkAll" type="checkbox" class="shrink-0 border-gray-200 rounded text-blue-600 pointer-events-none focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="checkall">
                      <span class="sr-only">Checkbox</span>
                    </label>
                  </th>
  
                  <th scope="col" class="w-1/4 px-6 py-3">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                        Category
                      </span>
                  </th>
  
                  <th scope="col" class="w1/4 px-6 py-3 text-left">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                        RSS Feeds
                      </span>
                  </th>
  
                  <th scope="col" class="w1/4 px-6 py-3 text-left">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                        Blog Posts
                      </span>
                  </th>
                  <th scope="col" class="px-6 py-3">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                        Actions
                    </span>
                  </th>
                </tr>
              </thead>
  
              <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="(item,idx) in categories">
                  <td class="text-center">
                      <label :for="`check${idx}`">
                        <input v-model="item.checked" type="checkbox" class="shrink-0 border-gray-200 rounded text-blue-600 pointer-events-none focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" :id="`check${idx}`">
                        <span class="sr-only">Checkbox</span>
                      </label>
                  </td>
                  <td class="text-center">
                        {{item.name}}
                  </td>
                  <td>
                    <div class="px-6 py-3">
                      {{ item.sources_count }}
                    </div>
                  </td>
                  <td>
                    <div class="px-6 py-3">
                      {{ item.posts_count }}                    
                    </div>
                  </td>
                  <td class="text-center">
                    <div class="group inline-flex items-center justify-center divide-x divide-gray-300 border border-gray-300 bg-white shadow-sm rounded-md transition-all dark:divide-gray-700 dark:bg-slate-700 dark:border-gray-700">
                      <a href="#" v-tooltip="'Delete'" @click="deleteCat(item.id)"
                      class="py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-l-md bg-white text-gray-700 align-middle focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                      </svg>
                      </a>
                    
                      <a href="#" @click="editCat(item)" class="py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-r-md text-gray-700 align-middle focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" v-tooltip="'Edit'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                      </a>
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
                  <span class="font-semibold text-gray-800 dark:text-gray-200">{{ categories.length}}</span> results
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
    <!-- End Card -->
    <v-modal v-if="showModal" :type="edit ? 'edit' : 'success'" :title="edit ? 'Edit category' : 'Add new category'" width="sm" @close="showModal = false; name = ''">
        <div class="flex flex-col items-center">
        <div class="mb-5">
            <h2 class="text-md font-bold md:text-xl md:leading-tight text-gray-800 dark:text-white">Provide a category name and a description(optional).</h2>
        </div>
        <div class="w-full max-w-xs">
            <input @keydown.enter="submit()" type="text" v-model="category.name" class="w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500" placeholder="Enter category name" required focus>
            <select v-model="category.parent_id" class="w-full mt-4 stext-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500">
              <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
            <textarea v-model="category.description" class="mt-4 w-full text-base px-4 py-2 border border-gray-300 focus:outline-none rounded-md focus:border-indigo-500"
                        id="description" name="description" rows="2" placeholder="Some description"></textarea>
        </div>
        </div>
    <div class="text-right mt-4">
      <button @click="showModal = false; edit = false" class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">Cancel</button>
      <button @click="submit()" class="mr-2 px-4 py-2 text-sm rounded text-white bg-teal-500 focus:outline-none hover:bg-teal-400">Save</button>
    </div>
    </v-modal>
  </template>
  
  <script setup>
  import { computed } from '@vue/reactivity';
  import { onMounted, ref, inject } from 'vue';
  import { createToast } from 'mosha-vue-toastify';
  import 'mosha-vue-toastify/dist/style.css'
  
  const categories = ref([])
  const showModal = ref(false)
  const edit = ref(false)
  const category = ref({
    id: null,
    name: '',
    description: '',
    parent_id: null
  })
  const editId = ref(0)

  onMounted(() => {
      loadCategories()
  })
  const loadCategories = () => {
    axios.get(`/posts/categories`)
          .then((response) => {
              categories.value = response.data
              createToast({
                  title: "Success",
                  description: "Categories loaded successfully",
              },
              {
                  type: "success",
                  timeout: 5000,
                  showIcon: true,
                  position: 'bottom-right',
              })
          })
  }
  const checkAll = () => {
      categories.value.forEach(element => {
          element.checked = !element.checked
      });
  }
  const editCat = cat => {
    showModal.value = true
    edit.value = true
    category.value = cat
    editId.value = cat.id
  }
  const newCat = () => {
    showModal.value = true
    category.value.name = ''
    category.value.description = ''
  }
  const selected = computed(()=>{
      return categories.value.filter(el => el.checked === true).length
  })
  const deleteSelected = () => {
      categories.value.forEach((element, index) => {
          if (element.checked === true) {
              deleteCat(element.id)
          }
      })
  }
  const deleteCat = id => {
    axios.post('/posts/categories/'+id, {
          _method: 'DELETE',
      }).then(() => {
            loadCategories()
            createToast({
                  title: "Success",
                  description: "Category was deleted",
              },
              {
                  type: "success",
                  timeout: 5000,
                  showIcon: true,
                  position: 'bottom-right',
              })})
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
  const submit = () => {
    if (edit.value)
      category.value._method = 'PUT'
    axios.post(`/posts/categories/${edit.value ? editId.value : ''}`, category.value).then(() => {
            loadCategories()
            showModal.value = false
            createToast({
                  title: "Success",
                  description: "Category is now published",
              },
              {
                  type: "success",
                  timeout: 5000,
                  showIcon: true,
                  position: 'bottom-right',
              })})
          .catch((response) => createToast({
                  title: "Error",
                  description: response.response.data.message ? response.response.data.message : "Something went wrong!",
              },
              {
                  type: "danger",
                  timeout: 5000,
                  showIcon: true,
                  position: 'bottom-right',
              }))
  }
  </script>