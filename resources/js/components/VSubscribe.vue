<template>
    <button v-text="this.active ? 'UnSubscribe' : 'Subscribe'" v-if="$signIn" @click="subscribe" :class="classes">
    </button>
</template>

<script>
    export default {
        data(){
            return {
                active: this.data
            }
        },

        props: ['data'],

        computed: {
            classes(){
                return [
                    this.active ? 'btn-indigo' : 'text-indigo-800 bg-white py-2 px-4', 
                    'text-xs rounded-xl focus:outline-none focus:ring-0']
            }
        },

        methods: {
            subscribe(){
                axios[
                    (this.active ? 'delete' : 'post')
                ](location.pathname + '/subscriptions')

                this.active = !this.active
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>