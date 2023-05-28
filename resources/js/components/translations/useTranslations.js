import { ref, watch } from 'vue'

// Notification
import { createToast } from 'mosha-vue-toastify'
import 'mosha-vue-toastify/dist/style.css'

export default function useTranslations() {

  const translations = ref([])

  // Table Handlers
  const tableColumns = [
    { label: 'ID', field:'key', isKey: true, sortable: true },
    { label: 'Original text', field: 'original', headerClasses: ["text-base"] },
    { label: 'Translation', field: 'value', headerClasses: ["text-base"], width: "35%" },
    { label: 'Created at', field: 'created_at', sortable: true, headerClasses: ["text-base"], width: "130px" },
    { label: 'Actions', field:'actions', headerClasses: ["text-base"] },
  ]
  const checkedRows = ref([])
  const perPage = ref(10)
  const totalTranslations = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('created_at')
  const sort = ref('desc')

  const getCurrentPage = (page) => currentPage.value = page
  const checkRow = checked => checkedRows.value = checked

  watch([searchQuery], () => {
    fetchTranslations()
  })  

  const fetchTranslations = (...args) => {
    if (args[2]) {
      sortBy.value = args[2]
      sort.value =  args[3]
    }
    
    axios.post('/translations', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sort: sort.value,
      })
      .then(response => {
        translations.value = response.data.data 
        totalTranslations.value  = response.data.meta.total
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
  const deleteSelected = () => {
    checkedRows.value.forEach(item => {
      deleteTranslation(item)
    })
  }
  const deleteTranslation = (id) => {
    axios.post('/translations/'+id, { _method: 'DELETE' })
    .then(() => {
      fetchTranslations()
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
    const saveTranslation = (data) => {
    data._method = 'PUT'
    axios.post('/translations/'+data.key, data)
    .then(() => {
      toggleEditing(data.key)
      fetchTranslations()
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
  const editing = ref([])
  const toggleEditing = index => {
      editing.value[index] = !editing.value[index]
  }

  return {
    fetchTranslations,
    saveTranslation,
    deleteTranslation,
    deleteSelected,
    tableColumns,
    checkedRows,
    perPage,
    currentPage,
    totalTranslations,
    searchQuery,
    perPageOptions,
    translations,
    editing,
    toggleEditing,
    getCurrentPage,
    checkRow,
  }
}
