<template>
    <div>
        <div v-if="notifications.length">
            <a @click="markAsRead(notification)" :href="notification.data.link"
              v-for="notification in notifications" class="dropdown-link"
              v-html="notification.data.message"
            >
            </a>
        </div>
        <div class="text-black text-opacity-50 dark:text-white dark:text-opacity-50" v-else>You have no notifications at this time.</div>
    </div>
</template>

<script>
export default {
    data() {
      return {
        notifications: [],
        endPoint: "/profiles/" + window.App.user.name + "/notifications",
      };
    },

    created() {
      axios.get(this.endPoint).then((response) => {
        this.notifications = response.data;
      });
    },

    methods: {
      markAsRead(notification) {
        axios.delete(
          "/profiles/" + App.user.name + "/notifications/" + notification.id
        );

        notifications = [];
      },
    },
};
</script>
