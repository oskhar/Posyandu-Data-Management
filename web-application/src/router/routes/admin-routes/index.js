import { checkPermittedAdminRoles, updateAdminSiteTitle } from "@/router/middlewares/admin-middleware";
import { requireAdminLogin } from "../../middlewares";
import { adminResletingRoutes } from "./admin-resleting-routes";
import { adminSiBinggoRoutes } from "./admin-sibinggo-routes";
import { ADMIN_ROLES } from "@/constants/admin-constants";

/** @type { import("vue-router").RouteRecordRaw } */
export const adminRoutes = {
  path: "/admin",
  beforeEnter: async (to, from, next) => {
    await requireAdminLogin(to, from, next)
    updateAdminSiteTitle()
  },
  component: () => import("../../../layouts/admin/admin-dashboard-layout.vue"),
  children: [
    {
      path: "dashboard",
      beforeEnter: checkPermittedAdminRoles([
        ADMIN_ROLES.PELINDUNG.id_jabatan,
        ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
        ADMIN_ROLES.SEKRETARIS.id_jabatan,
        ADMIN_ROLES.BENDAHARA.id_jabatan,
        ADMIN_ROLES.PENDAFTARAN.id_jabatan,
        ADMIN_ROLES.PENIMBANGAN.id_jabatan,
        ADMIN_ROLES.PENCATATAN.id_jabatan,
        ADMIN_ROLES.PENYULUHAN.id_jabatan,
        ADMIN_ROLES.KERJASAMA_KADER.id_jabatan,
        ADMIN_ROLES.PENJUAL.id_jabatan,
      ]),
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
      path: "events",
      beforeEnter: checkPermittedAdminRoles([
        ADMIN_ROLES.PELINDUNG.id_jabatan,
        ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
        ADMIN_ROLES.SEKRETARIS.id_jabatan,
        ADMIN_ROLES.BENDAHARA.id_jabatan,
        ADMIN_ROLES.PENDAFTARAN.id_jabatan,
        ADMIN_ROLES.PENIMBANGAN.id_jabatan,
        ADMIN_ROLES.PENCATATAN.id_jabatan,
        ADMIN_ROLES.PENYULUHAN.id_jabatan,
      ]),
      component: () => import("../../../pages/events.vue"),
    },
    {
      path: "edukasi",
      beforeEnter: checkPermittedAdminRoles([
        ADMIN_ROLES.PELINDUNG.id_jabatan,
        ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
        ADMIN_ROLES.SEKRETARIS.id_jabatan,
        ADMIN_ROLES.BENDAHARA.id_jabatan,
        ADMIN_ROLES.PENDAFTARAN.id_jabatan,
        ADMIN_ROLES.PENIMBANGAN.id_jabatan,
        ADMIN_ROLES.PENCATATAN.id_jabatan,
        ADMIN_ROLES.PENYULUHAN.id_jabatan,
      ]),
      component: () => import("../../../pages/edukasi.vue"),
    },
    {
      path: "galeri",
      beforeEnter: checkPermittedAdminRoles([
        ADMIN_ROLES.PELINDUNG.id_jabatan,
        ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
        ADMIN_ROLES.SEKRETARIS.id_jabatan,
        ADMIN_ROLES.BENDAHARA.id_jabatan,
        ADMIN_ROLES.PENDAFTARAN.id_jabatan,
        ADMIN_ROLES.PENIMBANGAN.id_jabatan,
        ADMIN_ROLES.PENCATATAN.id_jabatan,
        ADMIN_ROLES.PENYULUHAN.id_jabatan,
      ]),
      component: () => import("../../../pages/galeri.vue"),
    },
    {
      path: "data",
      children: [
        {
          path: "admin",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
          ]),
          component: () => import("../../../pages/admin-management-page.vue"),
        },
        {
          path: "format-1",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/admin-format-1/format-1.vue"),
        },
        {
          path: "format-1-create",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/admin-format-1/format-1-create.vue"),
        },
        {
          path: "format-2",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/format-2.vue"),
        },
        {
          path: "format-2-edit",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/format-2-edit.vue"),
        },
        {
          path: "format-3",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/format-3.vue"),
        },
        {
          path: "format-3-create",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/format-3-create.vue"),
        },
        {
          path: "format-4",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/format-4.vue"),
        },
        {
          path: "format-4-create",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
          ]),
          component: () => import("../../../pages/format-4-create.vue"),
        },
        {
          path: "format-5",
          beforeEnter: checkPermittedAdminRoles([]),
          component: () => import("../../../pages/format-5.vue"),
        },
        {
          path: "format-6",
          beforeEnter: checkPermittedAdminRoles([]),
          component: () => import("../../../pages/format-6.vue"),
        },
        {
          path: "format-7",
          beforeEnter: checkPermittedAdminRoles([]),
          component: () => import("../../../pages/format-7.vue"),
        },
        {
          path: "laporan",
          beforeEnter: checkPermittedAdminRoles([]),
          component: () => import("../../../pages/laporan.vue"),
        },
      ],
    },
    {
      path: "layanan",
      children: [
        adminResletingRoutes,
        ...adminSiBinggoRoutes,
        {
          path: "kader-gendong",
          beforeEnter: checkPermittedAdminRoles([
            ADMIN_ROLES.PELINDUNG.id_jabatan,
            ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
            ADMIN_ROLES.SEKRETARIS.id_jabatan,
            ADMIN_ROLES.BENDAHARA.id_jabatan,
            ADMIN_ROLES.PENDAFTARAN.id_jabatan,
            ADMIN_ROLES.PENIMBANGAN.id_jabatan,
            ADMIN_ROLES.PENCATATAN.id_jabatan,
            ADMIN_ROLES.PENYULUHAN.id_jabatan,
            ADMIN_ROLES.KERJASAMA_KADER.id_jabatan,
          ]),
          component: () =>
            import("../../../pages/admin-kader-gendong/kader-gendong-page.vue"),
        },
      ],
    },
    {
      path: "tentang",
      beforeEnter: checkPermittedAdminRoles([
        ADMIN_ROLES.PELINDUNG.id_jabatan,
        ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
        ADMIN_ROLES.SEKRETARIS.id_jabatan,
        ADMIN_ROLES.BENDAHARA.id_jabatan,
        ADMIN_ROLES.PENDAFTARAN.id_jabatan,
        ADMIN_ROLES.PENIMBANGAN.id_jabatan,
        ADMIN_ROLES.PENCATATAN.id_jabatan,
        ADMIN_ROLES.PENYULUHAN.id_jabatan,
      ]),
      component: () => import("../../../pages/tentang.vue"),
    },
  ],
};
