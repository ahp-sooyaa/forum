<template>
    <div>
        <div @click="isOpen = !isOpen" class="my-auto ml-2 bg-gray-800 hover:bg-gray-700 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white cursor-pointer" id="user-menu" aria-haspopup="true">
            <span class="sr-only">Open user menu</span>
            <img class="h-9 w-9 border-2 border-gray-800 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
            <span class="inline-block px-3 py-2 text-sm font-medium text-gray-300 hover:text-white">
                {{user.name}}
            </span>
        </div>
        <transition name="slide-fade">
            <div v-if="isOpen" class="profile-modal-container fixed top-0 right-0 w-full h-full">
                <div @click="isOpen = false" class="absolute top-0 right-0 w-full h-full"></div>
                <div name="profile-modal" class="absolute top-8 bottom-5 right-0 border border-gray-600 bg-gray-800 m-5 rounded-3xl w-1/5">
                    <div class="z-10 p-6">
                        <div class="-mx-1 mb-4 border-b-4 border-gray-400 flex">
                            <div @click="toggleTabs('me')" 
                                :class="[classes, openTab == 'me' ? 'border-b-4 border-blue-500 text-white' : 'text-gray-400']"
                            >
                                Me
                            </div>
                            <div @click="toggleTabs('noti')" 
                                :class="[classes, openTab == 'noti' ? 'border-b-4 border-blue-500 text-white' : 'text-gray-400']"
                            >
                                Notifications
                            </div>
                        </div>
                        <div :class="[openTab == 'me' ? 'block' : 'hidden']" class="space-y-3">
                            <a :href="'/profiles/'+user.name" class="dropdown-link text-center text-lg hover:bg-gray-500 hover:text-white text-gray-400">Your Profile</a>
                            <a :href="'/threads?by='+user.name" class="dropdown-link text-center text-lg hover:bg-gray-500 hover:text-white text-gray-400">Your Threads</a>
                            <a href="#" class="dropdown-link text-center text-lg hover:bg-gray-500 hover:text-white text-gray-400">Setting</a>

                            <button @click="logout" type="submit" class="dropdown-link text-center text-lg hover:bg-gray-500 hover:text-white text-gray-400">
                            Sign out
                            </button>
                        </div>
                        <div :class="[openTab == 'noti' ? 'block' : 'hidden']">
                            <v-notifications></v-notifications>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import VNotifications from './VNotifications.vue'
export default {
    components: { VNotifications },
    data(){
        return {
            isOpen: false,
            user: window.App.user,
            openTab: 'me'
        }
    },

    computed: {
        classes(){
            return [
                'cursor-pointer -mb-1 font-semibold py-2 flex-1 text-center hover:text-white text-sm tracking-wider'
            ]
        }
    },

    methods: {
        toggleTabs(tab){
            this.openTab = tab
        },
        logout(){
            axios.post('/logout')
                .then(window.location.href="/login")
        }
    }
}
</script>

<style scoped>
.v--modal {
    margin: 20px !important;
    width: 100px !important;
    height: 100vh !important;
    top: 20px !important;
}

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