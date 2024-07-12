import axios from "axios";

export const api = axios.create({
	baseURL: `http://127.0.0.1:8000/api`,
	headers: {
		"Content-Type": "application/json",
	},
})

api.interceptors.request.use(
  config => {
    const token = localStorage.getItem("tokenAuth");

    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
  },
  error => {
    return Promise.reject(error);
  },
);
