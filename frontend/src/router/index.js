import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import { useAuthStore } from '@/stores/auth.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/DashboardView.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/users',
      name: 'user',
      component: () => import('../views/UsersView.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/users/create',
      name: 'user-create',
      component: () => import('../views/CreateUsersView.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/users/edit',
      name: 'user-edit',
      component: () => import('../views/EditUsersView.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/products/create',
      name: 'product-create',
      component: () => import('../views/CreateProductView.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/products/edit',
      name: 'product-edit',
      component: () => import('../views/EditProductView.vue'),
      meta: {
        auth: true
      }
    },
    {
      path: '/logs',
      name: 'logs',
      component: () => import('../views/LogsView.vue'),
      meta: {
        auth: true
      }
    },
  ],
})

router.beforeEach((to, from, next) => {
  if (to.meta?.auth) {
    const auth = useAuthStore()
    if (auth.token != '' && auth.user) {
      next()
    } else {
      next({ name: 'login' })
    }
  } else {
    next()
  }
})

export default router
