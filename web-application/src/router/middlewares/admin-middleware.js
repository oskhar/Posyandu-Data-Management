import { useAdminRoleStore } from "@/stores/admin-role-store";

export const updateAdminSiteTitle = () => {
	document.title = "Admin SiDilan | Sistem Informasi Posyandu Melati RW 9";
}

export const checkPermittedAdminRoles = allowedRoles => (to, from, next) => {
	// Check if the user is an admin
	const adminRole = useAdminRoleStore()

	if (!adminRole.is(allowedRoles)) {
		next("/admin/dashboard")
	} else {
		next();
	}
}