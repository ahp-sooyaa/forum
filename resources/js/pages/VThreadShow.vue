<script>
    import VReplies from '../components/VReplies'
    export default {
        props: ['initialRepliesCount'],

        components: {VReplies},

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