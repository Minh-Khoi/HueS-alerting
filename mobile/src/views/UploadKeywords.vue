<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Tab Upload Keywords</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Tab Upload Keywords</ion-title>
        </ion-toolbar>
      </ion-header>

      <!-- <ExploreContainer name="Tab Upload Keywords" /> -->
      <div class="ion-text-center">
        Enter the keywords you want to search below
        <br />If you want to search multiples keywords, please seperate them with "+" character
      </div>
      <ion-input placeholder="add keywords here" v-model="keywords"></ion-input>
      <ion-button @click="submitKeywords()">SUBMIT</ion-button>
      <!-- <ion-alert
        :message="alertMes"
        :is-open="showAnnounce"
        @onDidDismiss="resetShowAnnounce()"
        :css-class="(alertMes=='failed') ? 'message_failed' : 'message_successfully'"
      ></ion-alert>-->
    </ion-content>
  </ion-page>
</template>

<script >
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonInput,
  IonButton,
  // IonAlert,
  alertController
} from "@ionic/vue";
import { backendAPI } from "../router/backendAPI.ts";
import { Storage } from "@ionic/storage";
import router from "../router/index.ts";
import { backendAPIlogin } from "../router/backendAPI.ts";
// import ExploreContainer from "../components/ExploreContainer.vue";

export default {
  data() {
    return {
      keywords: "",
      alertMes: "fuck",
      showAnnounce: false
    };
  },
  components: {
    // ExploreContainer,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonPage,
    IonInput,
    IonButton
    // IonAlert
  },
  methods: {
    async submitKeywords() {
      const ionicStorage = new Storage();
      await ionicStorage.create();
      let token = null;
      await ionicStorage.get("token_login").then(tokenInStorage => {
        token = tokenInStorage;
      });
      const formDatas = new FormData();
      formDatas.append("keywords_string", this.keywords);
      formDatas.append("task", "add_keywords");
      formDatas.append("token_remembered", token);
      // this.alertMes = "fuck";
      // this.showAnnounce = true;
      console.log(this.keywords);
      fetch(backendAPI, {
        body: formDatas,
        method: "POST"
      })
        .then(response => response.text())
        .then(async function(result) {
          // console.log(result);
          const alert = await alertController.create({
            cssClass:
              result == "failed" ? "message_failed" : "message_successfully",
            message: result
          });
          await alert.present();
        });
    }
  },
  async mounted() {
    const storageDealer = new Storage();
    await storageDealer.create();
    let loginToken = null;
    await storageDealer.get("token_login").then(token => {
      loginToken = token;
    });
    if (loginToken === null) {
      router.push({ name: "login" });
    }
  }
};
</script>

<style scoped>
ion-title {
  font-size: 1.5em;
}

ion-input {
  border: 0.5px solid blue;
}

.ion-text-center {
  color: green;
  margin-bottom: 1em;
}
</style>