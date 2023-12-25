import { createRouter, createWebHistory } from 'vue-router';
import { RouteName } from '@/constants/RouteName';
import useStore from '@/stores';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: { name: RouteName.LOGIN }
    },
    {
      path: '/home',
      name: RouteName.HOME_PAGE,
      component: () => import('@/views/pages/HomePageView.vue')
    },
    {
      path: '/p/:type/:pathMatch(.*)*',
      name: RouteName.DYNAMIC_PAGE,
      component: () => import('@/views/pages/DynamicPageView.vue')
    },
    // Admin Routes
    {
      path: '/',
      component: () => import('@/layouts/AdminPanelLayout.vue'),
      meta: { onlyGuest: false, requiresAuth: true },
      children: [
        {
          path: '/dashboard',
          name: RouteName.DASHBOARD,
          component: () => import('@/views/dashboard/DashboardView.vue')
        },
        {
          path: '/users',
          name: RouteName.USERS,
          component: () => import('@/views/users/index.vue')
        },
        {
          path: '/pages',
          name: RouteName.PAGES,
          component: () => import('@/views/pages/PagesView.vue')
        },
        {
          path: '/page/:action/:id?',
          name: RouteName.PAGE,
          component: () => import('@/views/pages/PageView.vue')
        }
      ]
    },
    // Auth Routes
    {
      path: '/',
      component: () => import('@/layouts/AuthLayout.vue'),
      meta: { onlyGuest: true, requiresAuth: false },
      children: [
        {
          path: '/login',
          name: RouteName.LOGIN,
          component: () => import('@/views/auth/LoginView.vue')
        },
        {
          path: '/forgot-password',
          name: RouteName.FORGOT_PASSWORD,
          component: () => import('@/views/auth/ForgotPasswordView.vue')
        },
        {
          path: '/reset-password',
          name: RouteName.RESET_PASSWORD,
          component: () => import('@/views/auth/ForgotPasswordView.vue')
        }
      ]
    }
  ]
});

router.beforeEach(async (to, from) => {
  const { auth, app } = useStore();
  app.setAppLoadingStatus(false);

  // check if route require authentication
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!auth.isAuthenticated) {
      return { name: RouteName.LOGIN };
    }
  }
  if (to.matched.some((record) => record.meta.onlyGuest)) {
    if (auth.isAuthenticated) {
      return { name: RouteName.DASHBOARD };
    }
  }
});

export default router;

/**
 *  https://router.vuejs.org/guide/essentials/route-matching-syntax.html#sensitive-and-strict-route-options
 *  https://router.vuejs.org/guide/essentials/passing-props.html#boolean-mode
 *  https://paths.esm.dev/?p=AAMeJSyAwR4UbFDAFxAcAGAIJXMAAA..#
 *
 */
