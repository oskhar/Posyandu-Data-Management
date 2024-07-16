import { createRouter, createWebHistory } from "vue-router";
import config from "@/@core/config";
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

      return response.status === 200;
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
    next("/admin/dashboard"); // Pengguna belum terautentikasi, alihkan ke halaman login.
  } else {
    next(); // Pengguna sudah terautentikasi, lanjutkan ke rute yang diminta.
  }
};

const router = createRouter({
  scrollBehavior: () => ({ top: 0 }),
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      component: () => import("../layouts/guest/guest-layout.vue"),
      children: [
        {
          path: "",
          component: () => import("../pages/guest-home-page/guest-home-page.vue"),
        },
        {
          path: "selengkapnya-card-edukasi",
          component: () => import("../pages/guest-edukasi-page/guest-edukasi-page.vue"),
        },
        {
          path: "selengkapnya-card-beritaacara",
          component: () => import("../pages/guest-berita-acara-page/guest-berita-acara-page.vue"),
        },
        {
          path: "tentang",
          component: () => import("../pages/guest-tentang-page/guest-tentang-page.vue"),
        },
        {
          path: "edukasi",
          component: () => import("../pages/edukasi.vue"),
        },
        {
          path: "berita-acara",
          component: () => import("../pages/berita-acara.vue"),
        },
        {
          path: "layanan",
          children: [
            { path: "remaja-peduli-stunting", component: () => import("../pages/resliting-page/resliting-page.vue") },
          ],
        },
      ],
    },
    {
      path: "/admin/",
      beforeEnter: requireAuth,
      component: () => import("../layouts/admin/admin-dashboard-layout.vue"),
      children: [
        {
          path: "test-api-kader-gendong",
          component: () => import("../pages/test-api-kader-gendong.vue"),
        },
        {
          path: "test-api-resleting",
          component: () => import("../pages/test-api-resleting.vue"),
        },
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
              path: "admin",
              component: () => import("../pages/admin.vue"),
            },
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
              path: "format-2-edit",
              component: () => import("../pages/format-2-edit.vue"),
            },
            {
              path: "format-3",
              component: () => import("../pages/format-3.vue"),
            },
            {
              path: "format-3-create",
              component: () => import("../pages/format-3-create.vue"),
            },
            {
              path: "format-4",
              component: () => import("../pages/format-4.vue"),
            },
            {
              path: "format-4-create",
              component: () => import("../pages/format-4-create.vue"),
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
            {
              path: "laporan",
              component: () => import("../pages/laporan.vue"),
            },
          ],
        },
        {
          path: "layanan/",
          children: [
            {
              path: "kader-gendong",
              component: () =>
                import("../pages/kader-gendong/kader-gendong-page.vue"),
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
      component: () => import("../layouts/blank-layout.vue"),
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
