import { Plugins, LocalNotificationsPlugin } from "@capacitor/core";

class NotificationPusher {
  message: string;
  beginningTime: number;
  waiting: number;

  localNotification: LocalNotificationsPlugin;

  constructor(mes: string, beginningHour: string, waitingSecond: number) {
    this.message = mes;
    this.waiting = waitingSecond;
    this.localNotification = Plugins.LocalNotifications;

    let todayString = new Date().toDateString();
    this.beginningTime = new Date(todayString + " " + beginningHour).getTime();
  }

  async getScheduleRegularly() {
    await this.localNotification.schedule({
      notifications: [
        {
          id: 1,
          title: "There are some post that may interest you!!",
          body: this.message,
          schedule: { every: "week" }
        }
      ]
    });
  }
}
