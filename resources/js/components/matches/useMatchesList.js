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
    { label: 'Date', field: 'date'},
    { label: 'Away Team', field: 'awayTeam' },
    { label: 'Status', field: 'status', sortable: true },
    { label: 'Actions', field:'actions' },
  ]
  const perPage = ref(10)
  const totalMatches = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)

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
    refetchData()
  })  

  const fetchMatches = (...args) => {
    if (args[2]) {
      sortBy.value = args[2]
      isSortDirDesc.value=  args[3] === 'asc' ? false : true
    }
    axios.post('/matchs/scheduled', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
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

  return {
    fetchMatches,
    tableColumns,
    perPage,
    currentPage,
    totalMatches,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    matches,
    getCurrentPage,
    refetchData,
  }
}
