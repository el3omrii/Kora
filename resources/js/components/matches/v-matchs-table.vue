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
                Match List from API. ({{ fixtures.response ? fixtures.response.length : 0 }})
              </p>
            </div>

            <div>
              <div>
                <button @click="publishSelected" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                    </svg>
                  Publish Selected ({{ selected }})
                </button>
              </div>
            </div>
          </div>
          <!-- End Header -->
          <table class="table w-full px-3 text-gray-400 border-separate space-y-6 text-sm">
				<thead class="bg-gray-800 text-gray-200">
					<tr>
						<th class="p-3"><input type="checkbox" v-model="toggleCheckAll" @click="checkAll()"></th>
						<th class="p-3">League</th>
            <th class="p-3">Home Team</th>
						<th class="p-3">Start Time</th>
						<th class="p-3">Away Team</th>
						<th class="p-3">Action</th>
					</tr>
				</thead>
				<tbody>
                    <tr v-for="(fixture, idx) in fixtures.response" class="bg-gray-800 text-center">
                      <td><input type="checkbox" v-model="fixture.checked"/></td>  
                      <td>
                        <img class="mx-auto w-20 h-auto rounded-md" :src="fixture.league.logo" /></td>
                        <td>
                            <div class="flex flex-col items-center">
                                <img class="w-12 h-auto rounded-md" :src="fixture.teams.home.logo" />
                                <span class="text-lg">{{ fixture.teams.home.name }}</span>
                            </div>
                        </td>
                        <td>{{ fixture.fixture.date }}</td>
                        <td>
                            <div class="flex flex-col items-center">
                                <img class="w-12 h-auto rounded-md" :src="fixture.teams.away.logo" />
                                <span class="text-lg">{{ fixture.teams.away.name }}</span>
                            </div>
                        </td>
                        <td>
                          <button @click="publish(idx)"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-indigo-800 text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                        Publish
                    </button>
                        </td>
                    </tr>
			    </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue'
import { createToast } from 'mosha-vue-toastify'
const fixtures = ref([])
const toggleCheckAll = ref(false)

const selected = computed(() => {
  if(fixtures.value.response)
    return fixtures.value.response.filter(item => item.checked === true).length
  return 0
})
onMounted(() => {
    axios.get('/api/matchs/fixtures').then((response) => {
        fixtures.value=response.data
        
        createToast({
                title: "Success",
                description: "Fixtures loaded from API",
            },
            {
                type: "success",
                timeout: 5000,
                showIcon: true,
                position: 'bottom-right',
            })
        })
        .catch(() => createToast({
                title: "Error",
                description: "Request failed!",
            },
            {
                type: "danger",
                timeout: 5000,
                showIcon: true,
                position: 'bottom-right',
            }))
    })
const checkAll = () => {  
  toggleCheckAll.value = !toggleCheckAll.value
  toggleCheckAll.value ? fixtures.value.response.forEach(element =>{ element.checked = true})
                 : fixtures.value.response.forEach(element =>{ element.checked = false})
}

const publishSelected = () => {
    fixtures.value.response.forEach((element, index) => {
        if (element.checked === true) {
            publish(index)
        }
    })
}
const publish = (idx) => {
    axios.post('/api/matchs/publish', {
        fixture_id: fixtures.value.response[idx].fixture.id,
        fixture_data: fixtures.value.response[idx]
    }).then(() => createToast({
                title: "Success",
                description: "Match is now published",
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
<style scoped>
	.table {
		border-spacing: 0 15px;
	}

	i {
		font-size: 1rem !important;
	}

	.table tr {
		border-radius: 20px;
	}

	tr td:nth-child(n+6),
	tr th:nth-child(n+6) {
		border-radius: 0 .625rem .625rem 0;
	}

	tr td:nth-child(1),
	tr th:nth-child(1) {
		border-radius: .625rem 0 0 .625rem;
	}
</style>