<template>
    <div @click="select" 
        :class="{'bg-sky-900 bg-opacity-75 text-white': selected, 'bg-white text-gray-600': !selected}"
        class="relative flex cursor-pointer rounded-lg p-2 shadow-md focus:outline-none">
        <div class="flex w-full items-center justify-between">
            <span>{{ category.name }}</span>
            <div v-if="selected" class="shrink-0 text-white">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="12" fill="#fff" fill-opacity="0.2"></circle>
                    <path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">                        
                    </path>
                </svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    category: Object,
    checked: Array
})
const emit = defineEmits(['categorySelected'])

const selected = ref()
const select = () => {
    selected.value = !selected.value
    emit('categorySelected', props.category, selected.value)
}
onMounted(() => {
   props.checked.forEach(element => {
    selected.value = element.id === props.category.id ? true : false
   })
})
</script>