import { createRouter, createWebHistory } from "vue-router";
import { adminRoutes } from "./routes/admin-routes";
import { authRoutes } from "./routes/auth-routes";
import { guestRoutes } from "./routes/guest-routes";
import { testRoutes } from "./routes/test-routes";

const router = createRouter({
  scrollBehavior(to) {
    if (to.hash) {
      return { el: to.hash, behavior: "smooth" }
    }

    return { top: 0, behavior: "instant" }
  },
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    guestRoutes,
    adminRoutes,
    authRoutes,
    testRoutes,
    {
      path: "/:pathMatch(.*)*",
      component: () => import("../pages/[...all].vue"),
    },
  ],
});

export default router;
