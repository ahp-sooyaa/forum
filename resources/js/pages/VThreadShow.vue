<script>
    import VReplies from '../components/VReplies'
    import VSubscribe from '../components/VSubscribe'
    
    export default {
        props: ['data'],

        components: {VReplies, VSubscribe},

        data(){
            return {
                repliesCount: this.data.replies_count,
                locked: this.data.locked,
                endPoint: `/threads/${this.data.slug}/locked`
            }
        },

        methods: {
            // reply(){
            //     window.events.$emit('reply', 'open');
            // }
            lock(){
                axios[
                    (this.locked ? 'delete' : 'post')
                ](this.endPoint)

                this.locked = !this.locked
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>