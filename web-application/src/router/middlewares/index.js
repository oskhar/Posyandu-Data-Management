import config from "@/@core/config";
import axios from "axios";

export const isAuthenticated = async () => {
  const url = `${config.urlServer}/api/auth`;
  const token = localStorage.getItem("tokenAuth");

  if (token) {
    const headers = {
      Authorization: token,
    };

    try {
      const response = await axios.post(url, {}, { headers });

      return response.status === 200;
    } catch (error) {
      localStorage.removeItem("tokenAuth");
      localStorage.removeItem("id_admin");
      console.error(error);

      return false;
    }
  } else {
    localStorage.removeItem("tokenAuth");
    localStorage.removeItem("id_admin");
    console.error("Auth Token tidak tersedia");

    return false;
  }
};

export const requireAuth = async (to, from, next) => {
  if (!(await isAuthenticated())) {
    next("/login"); // Pengguna belum terautentikasi, alihkan ke halaman login.
  } else {
    next(); // Pengguna sudah terautentikasi, lanjutkan ke rute yang diminta.
  }
};

export const requireAdmin = async (to, from, next) => {
  if (await isAuthenticated()) {
    next("/admin/dashboard"); // Pengguna sudah terautentikasi, alihkan ke halaman dashboard admin.
  } else {
    next(); // Pengguna belum terautentikasi, lanjutkan ke rute yang diminta.
  }
};