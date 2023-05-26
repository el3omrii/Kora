import { ref } from 'vue'

// Notification
import { createToast } from 'mosha-vue-toastify'
import 'mosha-vue-toastify/dist/style.css'

export default function useSettings() {

  const settings = ref([])

  const fetchSettings = () => {

    axios.get('/settings')
      .then(response => {
        settings.value = response.data.data 
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
  
  const storeSettings = (id) => {
    axios.post('/settings', settings.value)
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
   settings,
   fetchSettings,
   storeSettings
  }
}
