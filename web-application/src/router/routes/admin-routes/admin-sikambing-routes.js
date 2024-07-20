/** @type { import("vue-router").RouteRecordRaw[] } */
export const adminSiKambingRoutes = [
  {
    path: 'si-kambing',
    component: () => import('../../../pages/admin-si-kambing/admin-produk-page.vue'),
  },
  {
    path: 'si-kambing/produk/:id',
    component: () => import('../../../pages/admin-si-kambing/admin-detail-produk.page.vue'),
  },
]
