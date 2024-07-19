/** @type { import("vue-router").RouteRecordRaw[] } */
export const adminSiKambingRoutes = [
  {
    path: '/si-kambing',
    children: [
      {
        path: '',
        name: 'ReslitingLandingPage',
        component: () => import('../../../pages/resliting-landing-page/resliting-landing-page.vue'),
      },
      {
        path: 'produk/:id',
        name: 'ReslitingTantanganPage',
        component: () => import('../../../pages/resliting-tantangan-page/resliting-tantangan-page.vue'),
      },
    ],
  },
];
