export default{
    data() {
        return {
            items: []
        }
    },

    methods: {
        remove(item){
            // this.replies.splice(this.replies.findIndex(reply => reply.id == id), 1)
            this.replies.splice(item, 1)
            this.$emit('deleted')
        },
        add(reply){
            this.replies.push(reply)
            this.$emit('created')
        }
    }
}