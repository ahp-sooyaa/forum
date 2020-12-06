<template>
    <div class="relative inline-block text-left">
        <div @click="isOpen = !isOpen">
            <slot name="button"></slot>
        </div>
        
        <div 
            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
            v-if="isOpen"
        >
            <slot name="menu"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['btnName'],
        data(){
            return {
                isOpen: false
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>