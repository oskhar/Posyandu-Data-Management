import { defineStore } from "pinia"

export const useAdminRoleStore = defineStore("admin-role", {
	state: () => ({ currentRole: null }),
	actions: {
		setCurrentRole(role) {
			this.currentRole = role
		},
		resetRole() {
			this.currentRole = null
		},
		is(allowedRoles) {
			return allowedRoles.includes(this.currentRole) 
		},
		isNot(exceptionRoles) {
			return !exceptionRoles.includes(this.currentRole) 
		},
	},
})