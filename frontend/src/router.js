import { createMemoryHistory, createRouter } from 'vue-router'

import HomeView from './HomeView.vue'
import AddView from './AddView.vue'

const routes = [
  { path: '/', component: HomeView },
  { path: '/add', component: AddView },
]

const router = createRouter({
  history: createMemoryHistory(),
  routes,
})

export default router