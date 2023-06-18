import { ref, watch } from 'vue'

// Notification
import { createToast } from 'mosha-vue-toastify'
import 'mosha-vue-toastify/dist/style.css'

export default function usePostsList() {

  const refPostListTable = ref(null)

  const posts = ref([])

  // Table Handlers
  const tableColumns = [
    { label: 'ID', field:'id', isKey: true, sortable: true },
    { label: 'Image', field: 'image', headerClasses: ["text-base"] },
    { label: 'Title', field: 'title', headerClasses: ["text-base"], width: "35%" },
    { label: 'Categories', field: 'category', headerClasses: ["text-base"] },
    { label: 'Created at', field: 'created_at', sortable: true, headerClasses: ["text-base"], width: "130px" },
    { label: 'Status', field: 'status', sortable: true, headerClasses: ["text-base"] },
    { label: 'Actions', field:'actions' },
  ]
  const checkedRows = ref([])
  const perPage = ref(10)
  const totalPosts = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [{value:10, text:10}, {value:25, text:25}, {value:50, text:50}, {value:100, text:100}]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const sort = ref('desc')

  const getCurrentPage = (page) => currentPage.value = page
  const checkRow = checked => checkedRows.value = checked

  watch([currentPage, perPage, searchQuery], () => {
    fetchPosts()
  })  

  const fetchPosts = (...args) => {
    if (args[2]) {
      sortBy.value = args[2]
      sort.value =  args[3]
    }
    if (args[1])
      perPage.value = args[1]
    axios.post('/posts/fetch', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sort: sort.value,
      })
      .then(response => {
        posts.value = response.data.data 
        totalPosts.value  = response.data.meta.total
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
  const setFeatured = post => {
    axios.post('/posts/setfeatured/'+post)
  }
  const deleteSelected = () => {
    checkedRows.value.forEach(item => {
      deletePost(item)
    })
  }
  const deletePost = (id) => {
    axios.post('/posts/'+id, { _method: 'DELETE' })
    .then(() => {
      fetchPosts()
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
    fetchPosts,
    deletePost,
    deleteSelected,
    setFeatured,
    tableColumns,
    checkedRows,
    perPage,
    currentPage,
    totalPosts,
    searchQuery,
    perPageOptions,
    refPostListTable,
    posts,
    getCurrentPage,
    checkRow,
  }
}
