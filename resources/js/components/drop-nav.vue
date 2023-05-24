<template>
    <div class="block">
        <div @click="open = !open"
            class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded"
            :class="{'border-b-2 border-indigo-400 focus:outline-none focus:border-indigo-700 bg-gray-800 text-white' : active}">
            <div class="flex items-center space-x-2">
                <slot></slot>
                <span>{{ link.title }}</span>
            </div>
            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <div v-show="open" class="text-sm border-l-2 border-gray-800 mx-6 my-2.5 px-2.5 flex flex-col gap-y-1"
            >
            <a v-for="(item, index) in link.children" :key="index"
                :href="item.href" :class="{'bg-gray-800 text-white': item.href == link.currentRoute }" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                {{ item.text }}
            </a>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    link: Object,
    active: Boolean
})
let open = ref(props.active)
</script>
