import { defineStore } from 'pinia';

export const useAppStore = defineStore('app', {
  state: () => ({
    idx: 0,
    notifications: [],
    appLoading: false
  }),
  getters: {
    isAppLoading: (state) => state.appLoading
  },
  actions: {
    setAppLoadingStatus(loading: boolean) {
      this.appLoading = loading;
    },
    addNotification(notification: ISnackbar) {
      if (notification.id === 0) {
        notification.id = this.idx++;
      }

      this.notifications = [...this.notifications, notification];
      setTimeout(() => {
        this.removeNotification(notification.id);
      }, notification.timeout + 1000);
    },
    removeNotification(id: number) {
      let index = -1;
      for (let i = 0; i < this.notifications.length; i++) {
        if (this.notifications[i].id === id) {
          index = i;
          break;
        }
      }
      this.notifications.splice(index, 1);
    },

    success(message: string) {
      this.addNotification({
        id: 0,
        show: true,
        location: 'top right',
        icon: 'mdi-check-circle',
        message,
        timeout: 3000,
        type: 'success',
        color: 'success'
      });
    },
    error(error: any) {
      if (error) {
        const message = error?.data?.error.message || error || 'unknown error';

        this.addNotification({
          id: 0,
          show: true,
          location: 'top right',
          icon: 'mdi-alert-circle',
          message,
          timeout: 5000,
          type: 'error',
          color: 'error'
        });
      }
    }
  }
});
