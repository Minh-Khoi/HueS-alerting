<template>
  <ion-page class>
    <ion-item>
      <ion-label>User name</ion-label>
      <ion-input placeholder="User name" v-model="username" name="username"></ion-input>
    </ion-item>

    <ion-item>
      <ion-label>Password</ion-label>
      <ion-input placeholder="Password" v-model="password" type="password" name="password"></ion-input>
    </ion-item>

    <ion-item class="remember_field">
      <ion-label>Remember password ???</ion-label>
      <ion-checkbox color="primary" name="remember" v-model="loginRemembered"></ion-checkbox>
    </ion-item>
    <ion-button @click="onSubmit()">LOG IN</ion-button>
  </ion-page>
</template>

<script>
import {
  IonItem,
  IonInput,
  IonPage,
  IonLabel,
  IonCheckbox,
  IonButton
} from "@ionic/vue";
import { backendAPIlogin } from "../router/backendAPI.ts";
import router from "../router/index.ts";
import { Storage } from "@ionic/storage";

export default {
  components: {
    IonItem,
    IonInput,
    IonPage,
    IonLabel,
    IonCheckbox,
    IonButton
  },
  data() {
    return {
      loginRemembered: null,
      username: "",
      password: ""
    };
  },
  methods: {
    /** This function will load the "remembering token" from local storage of devices */
    async getTokenInStorage() {
      const storageDealer = new Storage();
      await storageDealer.create();
      let rememberingToken = null;
      await storageDealer.get("token_login").then(token => {
        rememberingToken = token;
      });
      return rememberingToken ? rememberingToken : false;
    },

    /** THis function will submit the detail of login form */
    async onSubmit() {
      const formDatas = new FormData();
      formDatas.append("login_submit", true);
      formDatas.append("remember", this.loginRemembered);
      formDatas.append("username", this.username);
      formDatas.append("password", this.password);
      // console.log(this.loginRemembered);

      await fetch(backendAPIlogin, {
        body: formDatas,
        method: "POST"
      })
        .then(response => response.text())
        .then(async function(resultJSON) {
          const result = JSON.parse(resultJSON);
          // console.log(typeof resultJSON);
          // First save the "token_login" to remember the current login
          if (result.token) {
            const storageDealer = new Storage();
            await storageDealer.create();
            await storageDealer.set("token_login", result.token);
          }
          // then push to the page "upload_keywords"
          if (result.announce != "login failed") {
            router.push({ name: "upload_keywords" });
          }
        });
    }
  },
  /**
   * When the component mounted, it will fetch to the "backendAPIlogin" first to check
   * if the login-action has been remembered before
   */
  async mounted() {
    const rememberingToken = await this.getTokenInStorage();
    console.log(rememberingToken);
    if (rememberingToken != false) {
      const formData = new FormData();
      formData.append("token_remembered", rememberingToken);
      await fetch(backendAPIlogin, {
        body: formData,
        method: "POST"
      })
        .then(response => response.text())
        .then(result => {
          const resultObject = JSON.parse(result);
          if (resultObject.announce == "found remembered logging in user") {
            // console.log("guck");
            router.push({ name: "upload_keywords" });
          }
        });
    }

    // There is 2 way to navigate with ionic vue router
    // router.push({ name: "upload_keywords" });
    // window.location.href =
    //   "http://" + window.location.host + "/tabs/UploadKeywords";

    // These code lines are only for testing ...
    // const storageDealer = new Storage();
    // await storageDealer.create();
    // //   storageDealer.set("fuck", "fuck u");
    // await storageDealer.get("fuck").then(strin => {
    //   console.log(strin);
    // });
    // // Testing end
  }
};
</script>

<style  scoped>
.remember_field {
  --ion-background-color: rgba(0, 128, 0, 0.411);
}
ion-checkbox {
  --background: white;
}
</style>