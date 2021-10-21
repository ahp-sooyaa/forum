<template>
  <div>
    <div
      id="user-menu" 
      @click="isOpen = !isOpen"
      class="my-auto ml-2 bg-light-secondary dark:bg-dark-secondary text-black dark:text-white hover:bg-gray-700 dark:hover:bg-light-primary hover:text-white dark:hover:text-black flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white cursor-pointer"
      aria-haspopup="true"
    >
      <!-- <span class="sr-only">Open user menu</span> -->
      <img
        width="36px"
        height="36px"
        :src="'https://gravatar.com/avatar/'+md5+'?s=68'"
        :alt="user.name+'s avatar'"
        class="border border-light-secondary dark:border-dark-secondary rounded-full"
      >
      <!-- <span class="inline-block px-3 py-2 text-sm font-medium">
                {{user.name}}
            </span> -->
    </div>
        
    <div
      v-if="isOpen"
      @click="isOpen = false"
      class="profile-modal-overlay z-40 fixed top-0 right-0 w-full h-full bg-black bg-opacity-40"
    />
    <transition name="slide-fade">
      <div
        v-if="isOpen"
        class="profile-modal z-50 overflow-y-auto fixed top-8 bottom-5 right-0 bg-light-secondary dark:bg-dark-secondary text-black dark:text-white m-5 rounded-3xl w-1/5"
      >
        <div class="p-6">
          <v-theme-switcher />
          <div class="-mx-1 mb-4 border-b-4 border-gray-400 flex">
            <div
              @click="toggleTabs('me')" 
              :class="[classes, openTab == 'me' ? 'border-b-4 border-accent text-black dark:text-white' : 'text-black text-opacity-50 dark:text-white dark:text-opacity-50']"
            >
              Me
            </div>
            <div
              @click="toggleTabs('noti')" 
              :class="[classes, openTab == 'noti' ? 'border-b-4 border-accent text-black dark:text-white' : 'text-black text-opacity-50 dark:text-white dark:text-opacity-50']"
            >
              Notifications
            </div>
          </div>
          <div
            :class="[openTab == 'me' ? 'block' : 'hidden']"
            class="space-y-3"
          >
            <a
              :href="'/profiles/'+user.name"
              class="dropdown-link text-center text-lg"
            >Your Profile</a>
            <a
              :href="'/threads?by='+user.name"
              class="dropdown-link text-center text-lg"
            >Your Threads</a>
            <a
              href="#"
              class="dropdown-link text-center text-lg"
            >Setting</a>

            <button
              @click="logout"
              type="submit"
              class="dropdown-link text-center text-lg"
            >
              Sign out
            </button>
          </div>
          <div :class="[openTab == 'noti' ? 'block' : 'hidden']">
            <v-notifications />
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import md5 from 'md5'
import VNotifications from './VNotifications.vue'
import VThemeSwitcher from './VThemeSwitcher.vue'
export default {
    components: { VNotifications, VThemeSwitcher },
    data(){
        return {
            isOpen: false,
            user: window.App.user,
            openTab: 'me',
        }
    },

    computed: {
        classes(){
            return [
                'cursor-pointer -mb-1 font-semibold py-2 flex-1 text-center hover:text-black dark:hover:text-white text-sm tracking-wider'
            ]
        },
        md5() {
            return md5(this.user.email)
        }
    },

    methods: {
        toggleTabs(tab){
            this.openTab = tab
        },
        logout(){
            window.axios.post('/logout')
                .then(window.location.href='/login')
        }
    }
}
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all .4s;
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(200px);
  opacity: 0;
}
</style>