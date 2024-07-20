import { api } from "@/lib/api";
import { clearAdminToken, clearUserToken } from "@/utils/auth-token";

export const isAdminAuthenticated = async () => {
  const token = localStorage.getItem("tokenAuth");

  if (!token) {
    clearAdminToken();

    return false;
  }

  try {
    const response = await api.post("/auth");

    return response.status === 200;
  } catch (error) {
    clearAdminToken();
    console.error(error);

    return false;
  }
};

export const isUserAuthenticated = async () => {
  const token = localStorage.getItem("tokenAuth");

  if (!token) {
    clearUserToken();

    return false;
  }

  try {
    const response = await api.post("/user/auth");

    return response.status === 200;
  } catch (error) {
    clearUserToken();
    console.error(error);

    return false;
  }
};

export const requireAdminLogin = async (to, from, next) => {
  const isAdmin = await isAdminAuthenticated().catch(() => false)

  if (!isAdmin) {
    next("/login");
  } else {
    next();
  }
};

export const requireUserLogin = async (to, from, next) => {
  const isUser = await isUserAuthenticated().catch(() => false)

  if (!isUser) {
    next("/login");
  } else {
    next();
  }
};
