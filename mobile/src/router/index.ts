import { createRouter, createWebHistory } from "@ionic/vue-router";
import { RouteRecordRaw } from "vue-router";
import Tabs from "../views/Tabs.vue";
import UploadKeywords from "../views/UploadKeywords.vue";
import ChangePassword from "../views/ChangePassword.vue";
import Login from "../views/Login.vue";

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
        name: "upload_keywords",
        component: () => UploadKeywords
      },
      {
        path: "ChangePassword",
        name: "change_password",
        component: () => ChangePassword
      }
    ]
  },
  {
    path: "/login/",
    name: "login",
    component: () => Login
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
