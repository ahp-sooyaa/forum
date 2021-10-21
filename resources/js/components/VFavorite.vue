<template>
  <button
    @click="toggleFavorite"
    class="bg-accent border dark:bg-gray-100 dark:text-gray-700 flex focus:outline-none h-8 items-center md:px-3 px-2 py-1 rounded-xl text-white"
  >
    <svg
      v-if="isFavorited"
      class="w-4 h-4"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 20 20"
      fill="currentColor"
    >
      <path
        fill-rule="evenodd"
        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
        clip-rule="evenodd"
      />
    </svg>
    <svg
      v-else
      class="w-4 h-4"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
      />
    </svg>

    <span
      v-show="count > 0"
      :class="classes"
    >
      {{ count }}
    </span>
  </button>
</template>

<script>
export default {
    props: {
        data: {
            type: Object,
            required: true
        }
    },

    data(){
        return {
            endPoint: `/replies/${this.data.id}/favorite`,
            count: this.data.favorites_count,
            isFavorited: this.data.isFavorited
        }
    },

    computed: {
        classes(){
            return [this.count > 0 ? 'ml-1' : '']
        }
    },

    methods: {
        toggleFavorite(){
            this.isFavorited ? this.delete() : this.create()
        },
        create(){
            window.axios.post(this.endPoint)
            this.count++
            this.isFavorited = true
        },
        delete(){
            window.axios.delete(this.endPoint)
            this.count--
            this.isFavorited = false
        }
    }
}
</script>
