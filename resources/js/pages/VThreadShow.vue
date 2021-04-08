<script>
    import VReplies from '../components/VReplies'
    import VSubscribe from '../components/VSubscribe'
    
    export default {
        props: ['initialRepliesCount'],

        components: {VReplies, VSubscribe},

        data(){
            return {
                repliesCount: this.initialRepliesCount
            }
        },

        methods: {
            reply(){
                window.events.$emit('reply', 'open');
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>