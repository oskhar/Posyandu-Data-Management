import config from "@/@core/config";
import axios from "axios";

export const api = axios.create({
	baseURL: new URL('/api', config.urlServer).toString(),
	headers: {
		"Content-Type": "application/json",
	},
})

api.interceptors.request.use(
  config => {
    const token = localStorage.getItem("tokenAuth");

    if (token) {
      config.headers.Authorization = `${token}`;
    }

    return config;
  },
  error => {
    return Promise.reject(error);
  },
);
