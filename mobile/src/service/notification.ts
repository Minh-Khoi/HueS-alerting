import { Plugins, LocalNotificationsPlugin } from "@capacitor/core";

export class NotificationPusher {
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

  async getRegularSchedule() {
    await this.localNotification.schedule({
      notifications: [
        {
          id: 1,
          title: "There are some post that may interest you!!",
          body: this.message,
          schedule: {
            at: new Date(this.beginningTime + this.waiting),
            repeats: false
          }
        }
      ]
    });
  }
}
