import { createRouter, createWebHistory } from "vue-router";
import config from "@/@core/config.vue";
import axios from "axios";

const isAuthenticated = async () => {
  const url = `${config.urlServer}/api/auth`;
  const token = localStorage.getItem("tokenAuth");

  if (token) {
    const headers = {
      Authorization: token,
    };

    try {
      const response = await axios.post(url, {}, { headers });
      const berhasil = response.status === 200;
      return berhasil;
    } catch (error) {
      localStorage.removeItem("tokenAuth");
      localStorage.removeItem("id_admin");
      console.error(error);
      return false;
    }
  } else {
    localStorage.removeItem("tokenAuth");
    localStorage.removeItem("id_admin");
    console.error("Auth Token tidak tersedia");
    return false;
  }
};

const requireAuth = async (to, from, next) => {
  if (!(await isAuthenticated())) {
    next("/login"); // Pengguna belum terautentikasi, alihkan ke halaman login.
  } else {
    next(); // Pengguna sudah terautentikasi, lanjutkan ke rute yang diminta.
  }
};

const requireGuest = async (to, from, next) => {
  if (await isAuthenticated()) {
    next("/dashboard"); // Pengguna belum terautentikasi, alihkan ke halaman login.
  } else {
    next(); // Pengguna sudah terautentikasi, lanjutkan ke rute yang diminta.
  }
};

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      component: () => import("../layouts/guest-layout.vue"),
      children: [
        {
          path: "",
          component: () => import("../pages/guest.vue"),
        },
      ],
    },
    {
      path: "/",
      beforeEnter: requireAuth,
      component: () => import("../layouts/default.vue"),
      children: [
        {
          path: "dashboard",
          component: () => import("../pages/dashboard.vue"),
        },
        {
          path: "account-settings",
          component: () => import("../pages/account-settings.vue"),
        },
        {
          path: "berita-acara",
          component: () => import("../pages/berita-acara.vue"),
        },
        {
          path: "edukasi",
          component: () => import("../pages/edukasi.vue"),
        },
        {
          path: "galeri",
          component: () => import("../pages/galeri.vue"),
        },
        {
          path: "data/",
          children: [
            {
              path: "format-1",
              component: () => import("../pages/format-1.vue"),
            },
            {
              path: "format-1-create",
              component: () => import("../pages/format-1-create.vue"),
            },
            {
              path: "format-2",
              component: () => import("../pages/format-2.vue"),
            },
            {
              path: "format-3",
              component: () => import("../pages/format-3.vue"),
            },
            {
              path: "format-4",
              component: () => import("../pages/format-4.vue"),
            },
            {
              path: "format-5",
              component: () => import("../pages/format-5.vue"),
            },
            {
              path: "format-6",
              component: () => import("../pages/format-6.vue"),
            },
            {
              path: "format-7",
              component: () => import("../pages/format-7.vue"),
            },
          ],
        },
        {
          path: "tentang",
          component: () => import("../pages/tentang.vue"),
        },
        {
          path: "form-layouts",
          component: () => import("../pages/form-layouts.vue"),
        },
      ],
    },
    {
      path: "/",
      beforeEnter: requireGuest,
      component: () => import("../layouts/blank.vue"),
      children: [
        {
          path: "login",
          component: () => import("../pages/login.vue"),
        },
        {
          path: "register",
          component: () => import("../pages/register.vue"),
        },
        {
          path: "/:pathMatch(.*)*",
          component: () => import("../pages/[...all].vue"),
        },
      ],
    },
  ],
});

export default router;
