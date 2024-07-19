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
  const isAdmin = await isAdminAuthenticated();
  const isUser = await isUserAuthenticated(); 

  if (!isAdmin && !isUser) {
    next("/login");
    
    return;
  } 
    
  if (isUser && !isAdmin) {
    next("/");
    
    return;
  }

  if (isAdmin && !isUser) {
    next();
  }
};

export const requireUserLogin = async (to, from, next) => {
  const isAdmin = await isAdminAuthenticated();
  const isUser = await isUserAuthenticated(); 

  if (!isAdmin && !isUser) {
    next("/login");
    
    return;
  } 
    
  if (!isUser && isAdmin) {
    next("/dashboard");
    
    return;
  }

  if (!isAdmin && isUser) {
    next();
  }
};
