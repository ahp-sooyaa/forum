<template>
  <div class="relative">
    <button
      @click="isOpen = !isOpen"
      class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none"
    >
      <span class="sr-only">View notifications</span>
      <!-- Heroicon name: bell -->
      <div class="bg-gray-600 rounded-xl p-1 hover:bg-gray-500">
        <svg
          class="h-6 w-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="#fff"
          viewBox="0 0 24 24"
          stroke="none"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
          />
        </svg>
      </div>
    </button>
    <div
      class="p-1 z-10 origin-top-right absolute right-0 mt-2 w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
      v-if="isOpen"
    >
      <div v-if="notifications.length">
        <a
          @click="markAsRead(notification)"
          :href="notification.data.link"
          v-for="notification in notifications"
          class="dropdown-link"
        >
          {{ notification.data.message }}
        </a>
      </div>
      <div v-else>You have no notifications at this time.</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: false,
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

<style lang="scss" scoped>
</style>