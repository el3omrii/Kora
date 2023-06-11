import { ref } from "vue"
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css'
export default function useNewPost () {
    //default image
    const defaultImage = ref(`data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>`)
    const imagePreview = ref()
    const imageFile = ref()
    const post = ref({
      title: '',
      slug: '',
      content: '',
    })
    const categories = ref([])
    const selectedCategories = ref([])
    const errors = ref([])
    const editMode = ref(false)
    
    //slug for url
    const slugify = str =>
      str
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\u0621-\u064A0-9-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '').replace(/-+$/, '')
    //image preview
    const onFileChange = e => {
      let files = e.target.files || e.dataTransfer.files
      if (!files.length)
        return;
      imageFile.value = files[0]
      createImage(files[0])
    }
    const resetImage = () => {
      imageFile.value = null
      imagePreview.value = null
    }
    const createImage = file => {
      imagePreview.value = new Image()
      let reader = new FileReader()

      reader.onload = (e) => {
        imagePreview.value = e.target.result
      }
      reader.readAsDataURL(file)
    }

    const updateCategory = (cat) => { 
      post.value.category_id = cat.id
      console.log(cat)
    }

    const submit = () => {
      post.value.categories = selectedCategories.value
      post.value.image = imageFile.value
      /*let data = new FormData()
      Object.keys(post.value).forEach(element => {
        data.append(element, post.value[element])
      });
      data.append('image', imageFile.value)*/
      const url = editMode.value ? `/posts/edit/${post.value.id}` : "/posts/new"
      axios.post(url, post.value, {headers: {'Content-Type': 'multipart/form-data'}})
        .then(() => createToast({
          title: "Success",
          description: "Article is now saved",
      },
      {
          type: "success",
          timeout: 5000,
          showIcon: true,
          position: 'bottom-right',
      }))
        .catch(error => {
            if (error.response.status == 422) {
                errors.value = error.response.data.errors;
            }
            console.log(error);
        });
    }
    return {
      slugify,
      onFileChange,
      resetImage,
      imagePreview,
      defaultImage,
      post,
      categories,
      selectedCategories,
      errors,
      editMode,
      submit,
      updateCategory
    }
}