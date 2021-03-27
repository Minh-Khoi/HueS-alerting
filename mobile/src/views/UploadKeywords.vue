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
      <ion-alert
        :message="alertMes"
        :is-open="showAnnounce"
        :css-class="(alertMes=='failed') ? 'message_failed' : 'message_successfully'"
      ></ion-alert>
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
  IonAlert,
  alertController
} from "@ionic/vue";
import { backendAPI } from "../router/backendAPI.ts";
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
    IonButton,
    IonAlert
  },
  methods: {
    async submitKeywords() {
      // const formDatas = new FormData();
      // formDatas.append("keywords", this.keywords);
      // formDatas.append("task", "add_keywords");
      // this.alertMes = "fuck";
      // this.showAnnounce = true;
      // console.log(this.showAnnounce);
      // fetch(backendAPI, {
      //   body: formDatas,
      //   method: "POST"
      // }).then(response => {
      //   this.alertMes =
      //     response.status == 200 ? "add keywords successfull" : "failed";
      //   this.showAnnounce = true;
      // });
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