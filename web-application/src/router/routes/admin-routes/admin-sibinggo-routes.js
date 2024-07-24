/** @type { import("vue-router").RouteRecordRaw[] } */
export const adminSiBinggoRoutes = [
  {
    path: 'si-binggo',
    component: () => import('../../../pages/admin-si-binggo/admin-produk-page.vue'),
  },
  {
    path: 'si-binggo/produk/:id',
    component: () => import('../../../pages/admin-si-binggo/admin-detail-produk.page.vue'),
  },
]
