import { createRouter, createWebHistory } from "@ionic/vue-router";
import { RouteRecordRaw } from "vue-router";
import Tabs from "../views/Tabs.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    redirect: "/tabs/UploadKeywords"
  },
  {
    path: "/tabs/",
    component: Tabs,
    children: [
      {
        path: "",
        redirect: "/tabs/UploadKeywords"
      },
      {
        path: "UploadKeywords",
        component: () => import("@/views/UploadKeywords.vue")
      },
      {
        path: "ChangePassword",
        component: () => import("@/views/ChangePassword.vue")
      },
      {
        path: "tab3",
        component: () => import("@/views/Tab3.vue")
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
