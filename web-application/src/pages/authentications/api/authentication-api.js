import { api } from "@/lib/api";

export const loginAdmin = async ({ email, password }) => {
	const { data } = await api.post(`/login`, { email_admin: email, password: password });
	
	return data;
}


export const loginUser = async ({ email, password }) => {
	const { data } = await api.post(`/user/login`, { email, password });
	
	return data;
}

export const registerUser = async ({ nama, email, password, whatsapp }) => {
	const { data } = await api.post(`/user/register`, { nama, email, password, whatsapp });
	
	return data;
}