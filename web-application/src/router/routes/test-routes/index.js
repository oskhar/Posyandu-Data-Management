import { requireUserLogin } from "@/router/middlewares";

/** @type { import("vue-router").RouteRecordRaw } */
export const testRoutes = {
  path: "/",
  component: () => import("../../../layouts/guest/guest-layout.vue"),
  children: [
    {
      path: "test-api-resleting",
      component: () => import("../../../pages/test-api-resleting.vue"),
    },
    {
      path: "test-api-produk",
      component: () => import("../../../pages/test-api-produk.vue"),
    },
  ],
};
