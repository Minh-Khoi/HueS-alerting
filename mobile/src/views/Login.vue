<template>
  <div class>
    <ion-item>
      <ion-label>User name</ion-label>
      <ion-input placeholder="User name" v-model="oldPassword" type="password"></ion-input>
    </ion-item>

    <ion-item>
      <ion-label>Password</ion-label>
      <ion-input placeholder="Password" v-model="oldPassword" type="password"></ion-input>
    </ion-item>
  </div>
</template>

<script>
import { IonItem } from "@ionic/vue";

export default {
  data() {
    return {
      //
    };
  },
  components: {
    IonItem
  }
};
</script>

<style>
</style>