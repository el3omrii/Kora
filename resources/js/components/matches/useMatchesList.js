import { ref, watch, computed } from 'vue'

// Notification
import { createToast } from 'mosha-vue-toastify'
import 'mosha-vue-toastify/dist/style.css'

export default function useMatchesList() {

  const matches = ref([])

  // Table Handlers
  const tableColumns = [
    { label: 'League', field: 'league' },
    { label: 'Home Team', field: 'homeTeam' },
    { label: 'Date', field: 'date', sortable: true},
    { label: 'Away Team', field: 'awayTeam' },
    { label: 'Status', field: 'status' },
    { label: 'Actions', field:'actions' },
  ]
  const perPage = ref(10)
  const totalMatches = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const sort = ref('desc')

  const dataMeta = computed(() => {
    const localItemsCount = refMatchesListTable.value ? refMatchesListTable.value.rows.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalMatches.value,
    }
  })

  const getCurrentPage = (page) => currentPage.value = page

  const refetchData = () => {
    //refPostListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery], () => {
    fetchMatches()
  })  

  const fetchMatches = (...args) => {
    if (args[2]) {
      sortBy.value = args[2]
      sort.value =  args[3]
    }
    if (args[1])
      perPage.value = args[1]
    axios.post('/matchs/scheduled', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sort: sort.value,
      })
      .then(response => {
        matches.value = response.data.data 
        totalMatches.value  = response.data.meta.total
      })
      .catch(() => {
          createToast({
            title: "Error",
            description: "Something went wrong!",
          },
          {
            type: "danger",
            timeout: 5000,
            showIcon: true,
            position: 'bottom-right',
          })
      })
  }

  const deleteMatch = (id) => {
    axios.post('/matchs/'+id, { _method: 'DELETE' })
    .then(() => {
      fetchMatches()
    })
    .catch(() => {
        createToast({
          title: "Error",
          description: "Something went wrong!",
        },
        {
          type: "danger",
          timeout: 5000,
          showIcon: true,
          position: 'bottom-right',
        })
    })
  }
  const updateMatch = (id, data = null) => {
    let postData = null
    data ? postData = { _method: 'PUT', 'live_url': data.live_url, 'overview_url': data.overview_url } : postData = { _method: 'PUT' }
    axios.post('/matchs/'+id, postData)
    .then(() => {
      fetchMatches()
    })
    .catch(() => {
        createToast({
          title: "Error",
          description: "Something went wrong!",
        },
        {
          type: "danger",
          timeout: 5000,
          showIcon: true,
          position: 'bottom-right',
        })
    })
  }

  return {
    fetchMatches,
    deleteMatch,
    updateMatch,
    tableColumns,
    perPage,
    currentPage,
    totalMatches,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    sort,
    matches,
    getCurrentPage,
    refetchData,
  }
}
