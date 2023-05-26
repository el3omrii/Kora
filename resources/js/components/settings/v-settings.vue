<template>
<div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 mb-6">
  <h3 class="mb-4 text-xl font-bold">General information</h3>
</div>
<form>
  <div>
    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Website title</label>
    <input type="text" name="title" id="title" class="shadow-lg-sm border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 block w-full p-2.5" placeholder="website title" required="">
  </div>
</form>
</template>
<script setup>
const {data: data} = useApi('/settings')
</script>