export default{
    data() {
        return {
            items: []
        }
    },

    methods: {
        remove(item){
            // this.replies.splice(this.replies.findIndex(reply => reply.id == id), 1)
            // console.log(this.replies);
            this.replies.splice(item, 1)
            this.$emit('deleted')
            this.fetch()
        },
        add(reply){
            this.replies.push(reply)
            this.$emit('created')
        }
    }
}