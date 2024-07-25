import Swal from "sweetalert2";

/**
 * @param {import("sweetalert2").SweetAlertOptions} options 
 */
export const errorToast = async options => {
	await Swal.fire({
		toast: true,
		position: "top",
		iconColor: "white",
		color: "white",
		background: "rgb(var(--v-theme-error))",
		showConfirmButton: false,
		timerProgressBar: true,
		timer: 4000,
		icon: "error",
		...options,
	});
}