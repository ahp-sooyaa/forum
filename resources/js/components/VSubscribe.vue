<template>
  <button
    v-if="$signIn"
    @click="subscribe"
    :class="classes"
    v-text="active ? 'UnSubscribe' : 'Subscribe'"
  />
</template>

<script>
export default {
    props: {
        data: Boolean
    },

    data(){
        return {
            active: this.data
        }
    },

    computed: {
        classes(){
            return [
                this.active ? 'bg-accent text-white hover:bg-accent-darker' : 'hover:text-accent bg-light-secondary dark:bg-dark-secondary border border-black hover:border-accent', 
                'text-xs py-2 px-4 font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-accent-darker focus:ring-opacity-75']
        }
    },

    methods: {
        subscribe(){
            window.axios[
                (this.active ? 'delete' : 'post')
            ](location.pathname + '/subscriptions')

            this.active = !this.active
        }
    }
}
</script>

<style lang="scss" scoped>

</style>