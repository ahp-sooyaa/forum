<template>
  <div class="card shadow-lg md:px-6">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button
            @click="isOpen = !isOpen"
            aria-expanded="false"
            class="inline-flex items-center justify-center p-2 rounded-md text-white bg-gray-700 focus:outline-none"
          >
            <span class="sr-only">Open main menu</span>
            <!-- Icon when menu is closed. -->
            <!--
                  Heroicon name: menu
                  
                  Menu open: "hidden", Menu closed: "block"
                -->
            <svg
              v-if="!isOpen"
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
            <!-- Icon when menu is open. -->
            <!--
                  Heroicon name: x

                  Menu open: "block", Menu closed: "hidden"
                -->
            <svg
              v-else
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex-shrink-0 flex items-center">
            <svg
              viewBox="0 0 316 316"
              xmlns="http://www.w3.org/2000/svg"
              class="w-auto h-8 fill-current text-black dark:text-white"
            >
              <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z" />
            </svg>
            <div class="hidden lg:block text-xl text-white font-bold ml-2">
              <a
                class="text-black uppercase tracking-wider dark:text-white"
                href="/threads"
              >Forum</a>
            </div>
          </div>
          <!-- @auth -->
          <div
            v-if="$signIn"
            class="hidden sm:block sm:ml-6"
          >
            <div class="flex space-x-4">
              <v-dropdown
                :width="'w-56'"
                :position="'left-0'"
              >
                <template #button>
                  <button
                    type="button"
                    class="flex nav-link"
                  >
                    Channels
                    <svg
                      class="-mr-1 ml-2 h-5 w-5"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </template>
                <template #menu>
                  <div class="p-1 max-h-80 overflow-y-auto">
                    <!-- the following $channels is sharing from app service provider -->
                    <!-- @foreach ($channels as $channel) -->
                    <a
                      v-for="channel in channels"
                      :key="channel.id"
                      :href="'/threads/'+channel.slug"
                      class="dropdown-link"
                    >{{ channel.name }}</a>
                    <!-- @endforeach -->
                  </div>
                </template>
              </v-dropdown>
              <v-dropdown
                :width="'w-56'"
                :position="'left-0'"
              >
                <template #button>
                  <button
                    type="button"
                    class="flex nav-link"
                  >
                    Browse
                    <svg
                      class="-mr-1 ml-2 h-5 w-5"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </template>
                <template #menu>
                  <div class="p-1 max-h-80 overflow-y-auto">
                    <a
                      class="dropdown-link"
                      href="/threads"
                    >All Threads</a>

                    <a
                      class="dropdown-link"
                      href="/threads?popular=1"
                    >Popular Threads</a>

                    <a
                      class="dropdown-link"
                      href="/threads?unanswered=1"
                    >Unanswered Threads</a>
                  </div>
                </template>
              </v-dropdown>
            </div>
          </div>
          <!-- @endauth -->
        </div>

        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <!-- @guest -->
          <div
            v-if="!$signIn"
            class="flex justify-between w-28"
          >
            <a
              class="text-black text-opacity-60 dark:text-white dark:text-opacity-50 hover:text-black dark:hover:text-white"
              href="/login"
            >Login</a>

            <a
              class="text-black text-opacity-60 dark:text-white dark:text-opacity-50 hover:text-black dark:hover:text-white"
              href="/register"
            >Register</a>
          </div>
          <!-- @else -->
          <div
            v-else
            class="flex"
          >
            <!-- <v-theme-switcher></v-theme-switcher> -->

            <a
              href="/threads/create"
              class="hidden md:block"
            >
              <button class="flex btn-accent text-sm ml-3">
                New Discussion
              </button>
            </a>

            <!-- Profile modal -->
            <v-profile-modal />
          </div>
          <!-- @endguest -->
        </div>
      </div>
    </div>

    <!--
          Mobile menu, toggle classes based on menu state.

          Menu open: "block", Menu closed: "hidden"
        -->
    <div
      v-if="isOpen"
      class="block sm:hidden"
    >
      <div class="px-2 pt-2 pb-3 space-y-1">
        <v-dropdown
          :width="'w-full'"
          :position="'left-0'"
        >
          <template #button>
            <button
              type="button"
              class="flex nav-link w-full"
            >
              Channels
              <svg
                class="-mr-1 ml-auto h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </template>
          <template #menu>
            <div class="p-1 max-h-80 overflow-y-auto">
              <a
                v-for="channel in channels"
                :key="channel.id"
                :href="'/threads/'+channel.slug"
                class="dropdown-link"
              >{{ channel.name }}</a>
            </div>
          </template>
        </v-dropdown>
        <v-dropdown
          :width="'w-full'"
          :position="'left-0'"
        >
          <template #button>
            <button
              type="button"
              class="flex nav-link w-full"
            >
              Browse
              <svg
                class="-mr-1 ml-auto h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </template>
          <template #menu>
            <div class="p-1 max-h-80 overflow-y-auto">
              <a
                class="dropdown-link"
                href="/threads"
              >All Threads</a>

              <a
                class="dropdown-link"
                href="/threads?popular=1"
              >Popular Threads</a>

              <a
                class="dropdown-link"
                href="/threads?unanswered=1"
              >Unanswered Threads</a>
            </div>
          </template>
        </v-dropdown>
      </div>
    </div>
  </div>
</template>

<script>
import VProfileModal from './VProfileModal.vue'
export default {
    components: { VProfileModal },
    props: {
        channels: {
            type: Array,
            required: true
        }
    },

    data(){
        return {
            user: window.App.user,
            isOpen: false,
        }
    },

    created() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    },
}
</script>

<style lang="scss" scoped>

</style>