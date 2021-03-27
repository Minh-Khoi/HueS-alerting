<template>
  <ion-page class>
    <ion-item>
      <ion-label>User name</ion-label>
      <ion-input placeholder="User name" v-model="oldPassword" type="password" name="username"></ion-input>
    </ion-item>

    <ion-item>
      <ion-label>Password</ion-label>
      <ion-input placeholder="Password" v-model="oldPassword" type="password" name="password"></ion-input>
    </ion-item>

    <ion-item class="remember_field">
      <ion-label>Remember password ???</ion-label>
      <ion-checkbox color="primary" name="remember"></ion-checkbox>
    </ion-item>
  </ion-page>
</template>

<script>
import { IonItem, IonInput, IonPage, IonLabel, IonCheckbox } from "@ionic/vue";
import { useRoute } from "vue-router";
import { backendAPIlogin } from "../router/backendAPI.ts";
import router from "../router/index.ts";
import { Storage } from "@ionic/storage";

const storageDealer = new Storage();
await storageDealer.create();

export default {
  data() {
    return {
      // loginRemembered: false
      // oldPassword: ""
    };
  },
  methods: {
    /** This function will load the "remembering token" from local storage of devices */
    async getTokenInStorage() {
      let rememberingToken = null;
      await storageDealer.get("rememberingToken").then(token => {
        rememberingToken = token;
      });
      return rememberingToken.length > 0 ? rememberingToken : false;
    }
  },
  components: {
    IonItem,
    IonInput,
    IonPage,
    IonLabel,
    IonCheckbox
  },
  /**
   * When the component mounted, it will fetch to the "backendAPIlogin" first to check
   * if the login-action has been remembered before
   */
  async mounted() {
    const rememberingToken = await this.getTokenInStorage();
    if (rememberingToken) {
      const formData = new FormData();
      formData.append("token_remembered", rememberingToken);
      await fetch(backendAPIlogin, {
        body: formData,
        method: "POST"
      })
        .then(response => response.text())
        .then(result => {
          let resultObject = JSON.parse(result);
          if (resultObject.announce == "You are logged in!") {
            console.log("guck");
            // router.push({ name: "upload_keywords" });
          }
        });
    }
    // There is to way to navigate with ionic vue router
    // router.push({ name: "upload_keywords" });
    // window.location.href =
    //   "http://" + window.location.host + "/tabs/UploadKeywords";
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