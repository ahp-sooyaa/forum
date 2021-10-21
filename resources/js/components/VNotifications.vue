<template>
  <div>
    <div v-if="notifications.length">
      <a
        v-for="notification in notifications"
        :key="notification.id"
        @click="markAsRead(notification)"
        :href="notification.data.link"
        class="dropdown-link"
        v-html="notification.data.message"
      />
    </div>
    <div
      v-else
      class="text-black text-opacity-50 dark:text-white dark:text-opacity-50"
    >
      You have no notifications at this time.
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: [],
            endPoint: '/profiles/' + window.App.user.name + '/notifications',
        }
    },

    created() {
        window.axios.get(this.endPoint).then((response) => {
            this.notifications = response.data
        })
    },

    methods: {
        markAsRead(notification) {
            window.axios.delete(
                '/profiles/' + window.App.user.name + '/notifications/' + notification.id
            )

            this.notifications = []
        },
    },
}
</script>
