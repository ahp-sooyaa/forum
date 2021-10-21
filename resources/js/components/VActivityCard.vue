<template>
  <div class="card shadow-md mb-2 p-5 rounded-2xl tracking-wide">
    <div class="text-lg text-black dark:text-white">
      <slot name="header" />
    </div>

    <div class="text-black text-opacity-50 dark:text-white dark:text-opacity-50">
      <slot name="body" />
    </div>
  </div>
</template>

<script>
export default {
        
}
</script>

<style lang="scss" scoped>

</style>