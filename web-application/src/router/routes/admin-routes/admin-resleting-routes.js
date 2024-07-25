import { ADMIN_ROLES } from "@/constants/admin-constants";
import { checkPermittedAdminRoles } from "@/router/middlewares/admin-middleware";

/** @type { import("vue-router").RouteRecordRaw } */
export const adminResletingRoutes = {
	path: "resleting",
	beforeEnter: checkPermittedAdminRoles([
    ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
    ADMIN_ROLES.KETUA.id_jabatan,
    ADMIN_ROLES.SEKRETARIS.id_jabatan,
    ADMIN_ROLES.BENDAHARA.id_jabatan,
    ADMIN_ROLES.PENDAFTARAN.id_jabatan,
    ADMIN_ROLES.PENIMBANGAN.id_jabatan,
    ADMIN_ROLES.PENCATATAN.id_jabatan,
    ADMIN_ROLES.PENYULUHAN.id_jabatan,
  ]),
	children: [
		{
			path: "tantangan",
			component: () => import('../../../pages/admin-resleting/tantangan-page.vue'),
		},
		{
			path: "tantangan/:id",
			children: [
				{
					path: "",
					component: () => import('../../../pages/admin-resleting/detail-tantangan.page.vue'),
				},
			],
		},
	],
}