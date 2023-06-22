import { ref } from 'vue'

// Notification
import { createToast } from 'mosha-vue-toastify'
import 'mosha-vue-toastify/dist/style.css'

export default function useSettings() {

  const settings = ref([])
  const blank = {
    website_title: null,
    website_description: null,
    cdn: null,
    cdn_url: null,
    current_season: null
  }
  const fetchSettings = () => {

    axios.get('/v1/settings')
      .then(response => {
        settings.value = response.data ? response.data : blank
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
    axios.post('/v1/settings', settings.value)
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
