<template>
    <div class="fixed w-full h-full top-0 left-0 flex items-center justify-center z-10" v-if="open">
      <div class="absolute w-full h-full bg-gray-900 opacity-50" @click="close"></div>
  
      <div class="absolute w-full max-h-full" :class="maxWidth">
        <div class="container bg-white overflow-hidden rounded-xl">
          <div class="px-4 py-4 flex">
            <div class="mr-4">
              <svg class="fill-current h-5 md:h-6 w-5 md:w-6 md:mr-1" xmlns="http://www.w3.org/2000/svg" :class="style.color" viewBox="0 0 24 24">
                <path v-if="type === 'info'" d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                <path v-if="type === 'edit'" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                <path v-if="type === 'warning'" d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z" />
                <path v-if="type === 'success'" d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z" />
                <path v-if="type === 'danger'" d="M0 10a10 10 0 1 1 20 0 10 10 0 0 1-20 0zm16.32-4.9L5.09 16.31A8 8 0 0 0 16.32 5.09zm-1.41-1.42A8 8 0 0 0 3.68 14.91L14.91 3.68z" />
              </svg>
            </div>
  
            <div class="max-h-10 flex-1">
              <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold" :class="style.color">{{ title }}</h3>
  
                <div @click="close" class="text-2xl hover:text-gray-600 text-gray-500 cursor-pointer select-none flex leading-none">
                  &#215;
                </div>
              </div>
            </div>
          </div>
          <!-- Content Slot-->
          <div class="m-4">
          <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import { computed } from '@vue/reactivity';
import { onBeforeUnmount, onMounted, ref } from 'vue';

    const open = ref(true)
    const emit = defineEmits(['close'])
    const props = defineProps({
        type: {
          type: String,
          default: "info",
        },
        title: {
          type: String,
          default: "",
        },
        header: {
          type: String,
          required: false,
          default: "",
        },
        width: {
          type: String,
          default: "full",
          validator: (value) => ["xs", "sm", "md", "lg", "full"].indexOf(value) !== -1,
        },
      })
     const close = () => { 
        open.value = false;
        emit("close");
     }
      const maxWidth = computed(()=> {
          switch (props.width) {
            case "xs":
              return "max-w-lg";
            case "sm":
              return "max-w-xl";
            case "md":
              return "max-w-2xl";
            case "lg":
              return "max-w-3xl";
            case "full":
              return "max-w-full";
          }
        })
        const style = computed(()=> {
          switch (props.type) {
            case "info":
              return {shade: "gray", color: "text-gray-600"}
            case "warning":
            return {shade: "yellow", color: "text-yellow-600"}
            case "success":
            return {shade: "teal", color: "text-teal-600"}
            case "edit":
            return {shade: "teal", color: "text-teal-600"}
            case "danger":
            return {shade: "red", color: "text-red-600"}
          }
        })
        
      onMounted(() => {
        const onEscape = (e) => {
          if (e.key === "Esc" || e.key === "Escape") {
            close()
          }
        }
        document.addEventListener("keydown", onEscape)
        onBeforeUnmount(() => {
        
        document.removeEventListener("keydown", onEscape)
      })
    })
      
  </script>
  