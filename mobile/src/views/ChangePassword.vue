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
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent
} from "@ionic/vue";
// import ExploreContainer from "../components/ExploreContainer.vue";

export default {
  components: {
    // ExploreContainer,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonPage
  }
};
</script>
<style scoped>
ion-title {
  font-size: 1.5em;
}
</style>