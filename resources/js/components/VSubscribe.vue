<template>
    <button v-text="this.active ? 'UnSubscribe' : 'Subscribe'" v-if="signIn" @click="subscribe" :class="classes">
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
            signIn(){
                return App.signIn
            },

            classes(){
                return [
                    this.active ? 'btn-indigo' : 'ring-1 ring-indigo-800 text-indigo-800 bg-white py-2 px-4', 
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
            // toggleSubscribe(){
            //     this.active ? this.unsubscribe() : this.subscribe()
            // },

            // subscribe(){
            //     axios.post(location.pathname + '/subscriptions')

            //     flash('Successfully Subscribed')

            //     this.active = true
            // },

            // unsubscribe(){
            //     axios.delete(location.pathname + '/subscriptions')

            //     flash('Successfully UnSubscribed')

            //     this.active = false
            // }
        }
    }
</script>

<style lang="scss" scoped>

</style>