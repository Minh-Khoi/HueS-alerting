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
      <h6>
        Enter the keywords you want to search here
        <br />If you want to search multiples keywords, please seperate them with "+" character
      </h6>
      <ion-input placeholder="add keywords here"></ion-input>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonInput
} from "@ionic/vue";
// import ExploreContainer from "../components/ExploreContainer.vue";

export default {
  components: {
    // ExploreContainer,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonPage,
    IonInput
  }
};
</script>

<style scoped>
ion-title {
  font-size: 1.5em;
}
</style>