<template>
    <div class="relative block md:inline-block text-left">
        <div @click="isOpen = !isOpen">
            <slot name="button"></slot>
        </div>
        
        <div v-if="isOpen">
            <div @click="isOpen = false" class="fixed top-0 right-0 w-full h-full"></div>
            <div 
                class="z-10 origin-top-left absolute mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                :class="classes"
            >
                <slot name="menu"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['width','position'],

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