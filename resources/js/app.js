import {createApp} from 'vue/dist/vue.esm-bundler.js';
import {ref} from 'vue';
import tooltip from "./directives/tooltip.js";
import DropNav from './components/drop-nav.vue';
import VAlert from './components/v-alert.vue';
import VModal from './components/v-modal.vue';
import VSourceCard from './components/v-source-card.vue';
import VFeedTable from './components/v-feed-table.vue';
import VMatchsTable from './components/matches/v-matchs-table.vue';
import VScheduledTable from './components/matches/v-scheduled-table.vue';
import PostsList from './components/posts/posts-list.vue';
import VTranslations from './components/translations/v-translations.vue';
import PostEditor from './components/posts/post-editor.vue';
import PostsCategories from './components/posts/posts-categories.vue';
import SettingsView from './components/settings/settings-view.vue';

import './bootstrap';

const app = createApp({
    setup() {
        const navOpen = ref(false);
        const showModal = ref(false);
        const showEditModal = ref(false);
        const myForm = ref(null);
        return {
            navOpen,
            showModal,
            showEditModal,
            myForm
        }
    }
});
app.component('drop-nav', DropNav);
app.component('v-alert', VAlert);
app.component('v-modal', VModal);
app.component('v-source-card', VSourceCard);
app.component('v-feed-table', VFeedTable);
app.component('v-matchs-table', VMatchsTable);
app.component('v-scheduled-table', VScheduledTable);
app.component('posts-list', PostsList);
app.component('v-translations', VTranslations);
app.component('post-editor', PostEditor);
app.component('posts-categories', PostsCategories);
app.component('settings-view', SettingsView);
app.directive('tooltip', tooltip);

app.mount("#app");
