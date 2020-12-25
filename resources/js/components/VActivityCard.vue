<template>
    <div class="bg-gray-800 shadow-md mb-2 p-5 rounded-2xl tracking-wide">
        <div class="text-lg text-white">
            <slot name="header"></slot>
        </div>

        <div class="text-gray-300">
            <slot name="body"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>