<template>
    <div>
        <div v-for="(reply, index) in replies">
            <v-reply :data="reply" @destroyed="remove(index)"></v-reply>
        </div>
        <v-new-reply @addedReply="add"/>
    </div>
</template>

<script>
    import VReply from './VReply.vue'
    import VNewReply from './VNewReply.vue'
    export default {
        props: ['data'],

        components: { VReply, VNewReply },

        data(){
            return {
                replies: this.data
            }
        },

        methods: {
            remove(index){
                this.replies.splice(index, 1)
                this.$emit('deleted')
            },
            add(reply){
                this.replies.push(reply)
                this.$emit('created')
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>