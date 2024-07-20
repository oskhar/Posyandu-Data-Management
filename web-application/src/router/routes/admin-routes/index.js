import { requireAdminLogin } from "../../middlewares";
import { adminReslitingRoutes } from "./admin-resliting-routes";
import { adminSiKambingRoutes } from "./admin-sikambing-routes";

/** @type { import("vue-router").RouteRecordRaw } */
export const adminRoutes = {
  path: "/admin",
  beforeEnter: requireAdminLogin,
  component: () => import("../../../layouts/admin/admin-dashboard-layout.vue"),
  children: [
    {
      path: "dashboard",
      component: () => import("../../../pages/dashboard.vue"),
    },
    {
      path: "account-settings",
      component: () =>
        import(
          "../../../pages/admin-account-settings-page/admin-account-account-settings.vue"
        ),
    },
    {
      path: "berita-acara",
      component: () => import("../../../pages/berita-acara.vue"),
    },
    {
      path: "edukasi",
      component: () => import("../../../pages/edukasi.vue"),
    },
    {
      path: "galeri",
      component: () => import("../../../pages/galeri.vue"),
    },
    {
      path: "data",
      children: [
        {
          path: "admin",
          component: () => import("../../../pages/admin-management-page.vue"),
        },
        {
          path: "format-1",
          component: () => import("../../../pages/format-1.vue"),
        },
        {
          path: "format-1-create",
          component: () => import("../../../pages/format-1-create.vue"),
        },
        {
          path: "format-2",
          component: () => import("../../../pages/format-2.vue"),
        },
        {
          path: "format-2-edit",
          component: () => import("../../../pages/format-2-edit.vue"),
        },
        {
          path: "format-3",
          component: () => import("../../../pages/format-3.vue"),
        },
        {
          path: "format-3-create",
          component: () => import("../../../pages/format-3-create.vue"),
        },
        {
          path: "format-4",
          component: () => import("../../../pages/format-4.vue"),
        },
        {
          path: "format-4-create",
          component: () => import("../../../pages/format-4-create.vue"),
        },
        {
          path: "format-5",
          component: () => import("../../../pages/format-5.vue"),
        },
        {
          path: "format-6",
          component: () => import("../../../pages/format-6.vue"),
        },
        {
          path: "format-7",
          component: () => import("../../../pages/format-7.vue"),
        },
        {
          path: "laporan",
          component: () => import("../../../pages/laporan.vue"),
        },
      ],
    },
    {
      path: "layanan",
      children: [
        adminReslitingRoutes,
        ...adminSiKambingRoutes,
        {
          path: "kader-gendong",
          component: () =>
            import("../../../pages/kader-gendong/kader-gendong-page.vue"),
        },
      ],
    },
    {
      path: "tentang",
      component: () => import("../../../pages/tentang.vue"),
    },
    {
      path: "form-layouts",
      component: () => import("../../../pages/form-layouts.vue"),
    },
  ],
};
