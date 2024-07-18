import { getFullImagePath } from "./get-full-image-path";

export const setAdminToken = ({ authToken, idAdmin, fotoProfile, namaLengkap, jabatan }) => {
	localStorage.setItem("tokenAuth", "Bearer " + authToken);
	localStorage.setItem("id_admin", idAdmin);
	localStorage.setItem("foto_profile", getFullImagePath(fotoProfile));
	localStorage.setItem("nama_lengkap", namaLengkap);
	localStorage.setItem("jabatan", jabatan);
}

export const setUserToken = ({ authToken, nama, whatsapp }) => {
	localStorage.setItem("tokenAuth", "Bearer " + authToken);
	localStorage.setItem("nama_lengkap", nama);
	localStorage.setItem("whatsapp", whatsapp);
}

export const clearAdminToken = () => {
	localStorage.removeItem("tokenAuth");
	localStorage.removeItem("id_admin");
	localStorage.removeItem("foto_profile");
	localStorage.removeItem("nama_lengkap");
	localStorage.removeItem("jabatan");
}

export const clearUserToken = () => {
	localStorage.removeItem("tokenAuth");
	localStorage.removeItem("nama_lengkap");
	localStorage.removeItem("whatsapp");
}