import { api } from "@/lib/api";

export const isAdminAuthenticated = async () => {
  const token = localStorage.getItem("tokenAuth");

  if (!token) {
    localStorage.removeItem("id_admin");

    return false;
  }

  try {
    const response = await api.post("/auth");

    return response.status === 200;
  } catch (error) {
    localStorage.removeItem("tokenAuth");
    localStorage.removeItem("id_admin");
    console.error(error);

    return false;
  }
};

export const isUserAuthenticated = async () => {
  const token = localStorage.getItem("tokenAuth");

  if (!token) {
    return false;
  }

  try {
    const response = await api.post("/user/auth");

    return response.status === 200;
  } catch (error) {
    localStorage.removeItem("tokenAuth");
    console.error(error);

    return false;
  }
};

export const requireAdminLogin = async (to, from, next) => {
  if (!(await isAdminAuthenticated())) {
    next("/login");
  } else {
    next();
  }
};

export const requireUserLogin = async (to, from, next) => {
  if (!(await isUserAuthenticated())) {
    next("/login");
  } else {
    next();
  }
};
