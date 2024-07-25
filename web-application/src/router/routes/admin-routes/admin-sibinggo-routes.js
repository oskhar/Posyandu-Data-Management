import { ADMIN_ROLES } from "@/constants/admin-constants";
import { checkPermittedAdminRoles } from "@/router/middlewares/admin-middleware";

/** @type { import("vue-router").RouteRecordRaw[] } */
export const adminSiBinggoRoutes = [
  {
    path: 'si-binggo',
    beforeEnter: checkPermittedAdminRoles([
      ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
      ADMIN_ROLES.KETUA.id_jabatan,
      ADMIN_ROLES.SEKRETARIS.id_jabatan,
      ADMIN_ROLES.BENDAHARA.id_jabatan,
      ADMIN_ROLES.PENJUAL.id_jabatan,
    ]),
    component: () => import('../../../pages/admin-si-binggo/admin-produk-page.vue'),
  },
  {
    path: 'si-binggo/produk/:id',
    beforeEnter: checkPermittedAdminRoles([
      ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
      ADMIN_ROLES.KETUA.id_jabatan,
      ADMIN_ROLES.SEKRETARIS.id_jabatan,
      ADMIN_ROLES.BENDAHARA.id_jabatan,
      ADMIN_ROLES.PENJUAL.id_jabatan,
    ]),
    component: () => import('../../../pages/admin-si-binggo/admin-detail-produk.page.vue'),
  },
]
