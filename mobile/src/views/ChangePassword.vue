<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Tab Change Password</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Tab Change Password</ion-title>
        </ion-toolbar>
      </ion-header>

      <!-- <ExploreContainer name="Tab Change Password" /> -->
      <ion-item>
        <ion-label>Old Password</ion-label>
        <ion-input placeholder="Old password" v-model="oldPassword" type="password"></ion-input>
      </ion-item>
      <ion-item>
        <ion-label>New Password</ion-label>
        <ion-input placeholder="new password" v-model="newPassword" type="password"></ion-input>
      </ion-item>
      <ion-item>
        <ion-label>retype New Password</ion-label>
        <ion-input placeholder="new password again" v-model="newPasswordRetyped" type="password"></ion-input>
      </ion-item>

      <ion-button @click="submit()">SUBMIT</ion-button>
      <!-- <ion-alert
        :message="alertMes"
        :is-open="showAnnounce"
        @onDidDismiss="showAnnounce=false"
        :css-class="(alertMes=='failed') ? 'message_failed' : 'message_successfully'"
      ></ion-alert>-->
    </ion-content>
  </ion-page>
</template>

<script >
import {
  IonPage,
  IonLabel,
  IonItem,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  // IonAlert,
  IonInput,
  IonButton,
  alertController
} from "@ionic/vue";
import { backendAPI } from "../router/backendAPI";
import { Storage } from "@ionic/storage";
// import ExploreContainer from "../components/ExploreContainer.vue";

export default {
  data() {
    return {
      oldPassword: "",
      newPassword: "",
      newPasswordRetyped: "",

      alertMes: ""
      // showAnnounce: false
    };
  },
  components: {
    // ExploreContainer,
    IonHeader,
    IonLabel,
    IonItem,
    IonToolbar,
    IonTitle,
    IonContent,
    IonPage,
    // IonAlert,
    IonInput,
    IonButton
  },
  methods: {
    async submit() {
      const ionicStorage = new Storage();
      await ionicStorage.create();
      let token = null;
      await ionicStorage.get("token_login").then(tokenInStorage => {
        token = tokenInStorage;
      });
      console.log(this.oldPassword);
      const formDatas = new FormData();
      formDatas.append("token_remembered", token);
      formDatas.append("old_password", this.oldPassword);
      formDatas.append("new_password", this.newPassword);
      formDatas.append("new_password_retyped", this.newPasswordRetyped);
      formDatas.append("task", "change_password");

      fetch(backendAPI, {
        body: formDatas,
        method: "POST"
      })
        .then(response => response.text())
        .then(async function(result) {
          // this.alertMes = result;
          const alert = await alertController.create({
            cssClass:
              result == "failed" ? "message_failed" : "message_successfully",
            message: result
          });
          await alert.present();
        });
    }
  },
  resetShowAnnounce() {
    console.log("fuck you");
    this.showAnnounce = false;
  }
};
</script>
<style scoped>
ion-title {
  font-size: 1.5em;
}
</style>