import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from '@/layouts/DefaultLayout.vue'

const isAuthenticated = () => {
    return !!localStorage.getItem("userToken"); 
};

const router = createRouter({
    history: createWebHistory(),
    routes: [
      {
        path: '/',
        component: DefaultLayout,
        meta: {
            title: 'DefaultLayout',
            requiresAuth: true, 
        },
        children: [
            {
                path: 'change-password',
                name: 'ChangePassword',
                component: () => import('@/pages/Account/ChangePassword.vue'),
                meta: {
                    title: 'Change Password',
                    requiresAuth: true, 
                },
            },
            { 
                path: "/dashboard", 
                name: "Dashboard", 
                component: () => import('@/pages/Dashboard.vue'),
                meta: {
                    title: 'Dashboard',
                    requiresAuth: true, 
                },
            },
            { 
                path: "/profile", 
                name: "Profile", 
                component: () => import('@/pages/Account/Profile.vue'),
                meta: {
                    title: 'Profile',
                    requiresAuth: true, 
                },
            },
            // Library
            { 
                path: "/library", 
                name: "Library", 
                component: () => import('@/pages/Library/Library.vue'),
                meta: {
                    title: 'Library',
                    requiresAuth: true, 
                },
            },

            // Settings
            { 
                path: "/setting", 
                name: "Setting", 
                component: () => import('@/pages/Settings/Setting.vue'),
                meta: {
                    title: 'Setting',
                    requiresAuth: true, 
                },
            },
            // History
            { 
                path: "/history", 
                name: "History", 
                component: () => import('@/pages/History/History.vue'),
                meta: {
                    title: 'History',
                    requiresAuth: true, 
                },
            },
        ]
      },
      {
        path: '/login',
        name: 'Login',
        component: () => import('@/pages/Account/Login.vue')
      }
    ]
  })

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated()) {
        next({ name: "Login" });
    } else {
        next();
    }
});

export default router;
