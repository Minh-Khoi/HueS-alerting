<template>
  <ion-page>
    <ion-tabs>
      <ion-tab-bar slot="bottom">
        <ion-tab-button tab="tab1" href="/tabs/UploadKeywords">
          <ion-icon :icon="triangle" />
          <ion-label>keywords</ion-label>
        </ion-tab-button>

        <ion-tab-button tab="tab2" href="/tabs/ChangePassword">
          <ion-icon :icon="ellipse" />
          <ion-label>password</ion-label>
        </ion-tab-button>
        <ion-tab-button tab="tab3" href="/tabs/NotificationSetting">
          <ion-icon :icon="ellipse" />
          <ion-label>Notification</ion-label>
        </ion-tab-button>
      </ion-tab-bar>
    </ion-tabs>
  </ion-page>
</template>

<script lang="ts">
import {
  IonTabBar,
  IonTabButton,
  IonTabs,
  IonLabel,
  IonIcon,
  IonPage
} from "@ionic/vue";
import { ellipse, square, triangle } from "ionicons/icons";

export default {
  name: "Tabs",
  components: { IonLabel, IonTabs, IonTabBar, IonTabButton, IonIcon, IonPage },
  setup() {
    return {
      ellipse,
      square,
      triangle
    };
  }
};
</script>