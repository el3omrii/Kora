<template>
<div class="w-full flex flex-wrap gap-2 items-center">
  <div v-for="(tag, idx) in selectedTags" class="bg-blue-100 inline-flex items-center text-sm rounded mt-2 mr-1 overflow-hidden">
      <span class="ml-2 mr-1 leading-relaxed truncate text-gray-800 max-w-xs px-1">{{tag.name}}</span>
      <button @click.prevent="removeTag(idx)" class="w-6 h-8 inline-block align-middle text-gray-500 bg-blue-200 focus:outline-none">
        <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/></svg>
      </button>
    </div>
    <Combobox v-model="selected">
      <div class="relative mt-1">
        <div
          class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
        >
          <ComboboxInput
            class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
            :displayValue="(tag) => tag.name"
            @change="query = $event.target.value"
            @keyup.enter="handleEntry()"
          />
          <ComboboxButton
            class="absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <ChevronUpDownIcon
              class="h-5 w-5 text-gray-400"
              aria-hidden="true"
            />
          </ComboboxButton>
        </div>
        <TransitionRoot
          leave="transition ease-in duration-100"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
          @after-leave="query = ''"
        >
          <ComboboxOptions
            class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
          >
            <div
              v-if="filteredTags.length === 0 && query !== ''"
              class="relative cursor-default select-none py-2 px-4 text-gray-700"
            >
              Nothing found. Press Enter to create {{ query }}
            </div>
            <ComboboxOption
              v-for="tag in filteredTags"
              as="template"
              :key="tag.id"
              :value="tag"
              v-slot="{ selected, active }"
            >
              <li @click="selectedTags.push(tag)"
                class="relative cursor-default select-none py-2 pl-10 pr-4"
                :class="{
                  'bg-teal-600 text-white': active,
                  'text-gray-900': !active,
                }"
              >
                <span
                  class="block truncate"
                  :class="{ 'font-medium': selected, 'font-normal': !selected }"
                >
                  {{ tag.name }}
                </span>
                <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3"
                  :class="{ 'text-white': active, 'text-teal-600': !active }"
                >
                  <CheckIcon class="h-5 w-5" aria-hidden="true" />
                </span>
              </li>
            </ComboboxOption>
          </ComboboxOptions>
        </TransitionRoot>
      </div>
    </Combobox>
</div>
</template>
<script setup>
import { ref, computed, onMounted, nextTick, onBeforeUpdate } from 'vue'
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    tags: Array,
    postTags: Array
})
const availableTags = ref() // ref(props.tags)
const selectedTags = ref() //ref(props.postTags)
onBeforeUpdate(() => {
  nextTick(() => {
    availableTags.value = props.tags
    selectedTags.value = props.postTags
  })
})
const emit = defineEmits(['select-tags'])
let selected = ref({})
let query = ref('')
const filteredTags = computed(() =>
    query.value === ''
      ? availableTags.value
      : availableTags.value.filter((tag) => {
          return tag.name.toLowerCase().includes(query.value.toLowerCase())
        })
  )
const handleEntry = () => {
  let tag = null
  if (filteredTags.value.length === 0 && query.value !== '') {
    tag = { id: null, name: query.value}
    availableTags.value.push(tag)
    selectedTags.value.push(tag)
  } else {
    tag = selected.value
    selectedTags.value.push(tag)
  }
  emit("selectTags", selectedTags.value)
}
const removeTag = (index) => {
  console.log(index)
  selectedTags.value.splice(index, 1)
  emit("select-tags", selectedTags.value)
}
</script>