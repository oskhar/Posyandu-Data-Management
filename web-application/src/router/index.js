import { createRouter, createWebHistory } from "vue-router";
import { adminRoutes } from "./routes/admin-routes";
import { authRoutes } from "./routes/auth-routes";
import { guestRoutes } from "./routes/guest-routes";

const router = createRouter({
  scrollBehavior: () => ({ top: 0 }),
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    guestRoutes,
    adminRoutes,
    authRoutes,
    {    
      path: "/:pathMatch(.*)*",
      component: () => import("../pages/[...all].vue"),
    },
  ],
});

export default router;
