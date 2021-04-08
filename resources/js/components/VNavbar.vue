<template>
    <nav class="bg-gray-800 md:px-6">
      <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
          <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
            <!-- Mobile menu button-->
            <button @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 rounded-md text-white bg-gray-700 focus:outline-none" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <!-- Icon when menu is closed. -->
              <!--
                Heroicon name: menu

                Menu open: "hidden", Menu closed: "block"
              -->
              <svg v-if="!isOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!-- Icon when menu is open. -->
              <!--
                Heroicon name: x

                Menu open: "block", Menu closed: "hidden"
              -->
              <svg v-else class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
            <div class="flex-shrink-0 flex items-center">
              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Logo">
              <div class="hidden lg:block text-xl text-white font-bold ml-2">
                <a class="text-white" href="/threads">Forum</a>
              </div>
            </div>
            <!-- @auth -->
              <div v-if="signIn" class="hidden sm:block sm:ml-6">
                <div class="flex space-x-4">
                  <v-dropdown>
                    <template #button>
                      <button type="button" class="flex nav-link">
                        Channels
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </template>
                    <template #menu>
                      <div class="p-1 max-h-80 overflow-y-auto">
                          <!-- the following $channels is sharing from app service provider -->
                          <!-- @foreach ($channels as $channel) -->
                              <a v-for="channel in channels" :href="'/threads/'+channel.slug" class="dropdown-link">{{channel.name}}</a>
                          <!-- @endforeach -->
                      </div>
                    </template>
                  </v-dropdown>
                </div>
              </div>
            <!-- @endauth -->
          </div>

          <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <!-- @guest -->
              <div v-if="!signIn" class="flex justify-between w-28">
                <a class="text-indigo-200 hover:text-white" href="/login">Login</a>

                <a class="text-indigo-200 hover:text-white" href="/register">Register</a>
              </div>
            <!-- @else -->
                <div v-else class="flex">
                    <v-notifications></v-notifications>

                    <a href="/threads/create" class="hidden sm:block">
                      <button class="flex btn-indigo text-sm font-medium ml-3">
                        <svg class="h-5 w-5 mr-1 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        New Discussion
                      </button>
                    </a>

                  <!-- Profile dropdown -->
                    <v-dropdown class="ml-3">
                      <template #button>
                        <div class="bg-gray-800 hover:bg-gray-700 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white cursor-pointer" id="user-menu" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-9 w-9 border-2 border-gray-800 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <span class="inline-block px-3 py-2 text-sm font-medium text-gray-300 hover:text-white">
                                <!-- {{Auth::user()->name}} -->
                                {{user.name}}
                            </span>
                        </div>
                      </template>

                      <template #menu>
                        <div class="p-1">
                            <a :href="'/profiles/'+user.name" class="dropdown-link">Your Profile</a>
                            <a :href="'/threads?by='+user.name" class="dropdown-link">Your Threads</a>
                            <a href="#" class="dropdown-link">Setting</a>
                            
                            <button @click="logout" type="submit" class="dropdown-link text-left">
                              Sign out
                            </button>
                        </div>
                      </template>
                    </v-dropdown>
                </div>
            <!-- @endguest -->
            </div>
        </div>
      </div>

      <!--
        Mobile menu, toggle classes based on menu state.

        Menu open: "block", Menu closed: "hidden"
      -->
      <div v-if="isOpen" class="block sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/threads/create">
              <button class="flex btn-indigo text-sm font-medium">
                <svg class="h-5 w-5 mr-1 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Discussion
              </button>
            </a>
            <v-dropdown>
              <template #button>
                <button type="button" class="flex nav-link w-full">
                  Channels
                  <svg class="-mr-1 ml-auto h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
              </template>
              <template #menu>
                <div class="p-1 max-h-80 overflow-y-auto">
                    <a v-for="channel in channels" :href="'/threads/'+channel.slug" class="dropdown-link">{{channel.name}}</a>
                </div>
              </template>
            </v-dropdown>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900">Hi Dashboard</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Team</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Projects</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Calendar</a>
        </div>
      </div>
    </nav>
</template>

<script>
    export default {
        props: ['channels'],

        data(){
            return {
                user: window.App.user,
                isOpen: false
            }
        },

        computed: {
            signIn(){
                return window.App.signIn;
            }
        },

        methods: {
            logout(){
                axios.post('/logout')
                    .then(window.location.href="/login")
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>