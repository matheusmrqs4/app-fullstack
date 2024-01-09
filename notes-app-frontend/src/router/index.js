import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import { isAuthenticated } from '@/utils/auth.js';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/RegisterView.vue')
    },
    {
      path: '/notes/create',
      name: 'notes-create',
      component: () => import('../views/NotesCreateView.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/notes/list',
      name: 'notes-list',
      component: () => import('../views/NotesListView.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/notes/show/:id',
      name: 'notes-show',
      component: () => import('../views/NotesShowView.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/notes/edit/:id',
      name: 'notes-edit',
      component: () => import('../views/NotesEditView.vue'),
      meta: { requiresAuth: true }
    }    
  ]
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresAuth && !(await isAuthenticated())) {
    next({ name: 'login' });
  } else {
    next();
  }
});

export default router;
