<template>
  <div class="relative block md:inline-block text-left">
    <div @click="isOpen = !isOpen">
      <slot name="button" />
    </div>
        
    <div v-if="isOpen">
      <div
        @click="isOpen = false"
        class="fixed top-0 right-0 w-full h-full z-30"
      />
      <div 
        class="z-50 origin-top-left absolute mt-2 rounded-md shadow-md bg-light-secondary dark:bg-dark-secondary dark:text-white ring-1 ring-black ring-opacity-5"
        :class="classes"
      >
        <slot name="menu" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        width: {
            type: String,
            required: true
        },
        position: {
            type: String,
            required: true
        }
    },

    data(){
        return {
            classes: [
                this.width,
                this.position
            ],
            isOpen: false
        }
    },
}
</script>

<style lang="scss" scoped>

</style>