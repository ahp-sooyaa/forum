<script>
import VReplies from '../components/VReplies'
import VSubscribe from '../components/VSubscribe'
    
export default {

    components: {VReplies, VSubscribe},
    props: {
        data: {
            type: Object,
            required: true
        }
    },

    data(){
        return {
            isEdit: false,
            body: this.data.body,
            title: this.data.title,
            repliesCount: this.data.replies_count,
            locked: this.data.locked,
            endPoint: `/locked-threads/${this.data.slug}`
        }
    },

    methods: {
        reply(){
            window.events.$emit('reply', 'open')
        },
        lock(){
            window.axios[
                (this.locked ? 'delete' : 'post')
            ](this.endPoint)

            this.locked = !this.locked
        },
        update(){
            window.axios.patch(`/threads/${this.data.channel.slug}/${this.data.slug}/`, { title: this.title, body: this.body})
                .then(() => {
                    this.isEdit= false,
                    this.data.body = this.body
                    this.data.title = this.title

                    window.flash('Your thread has been updated!')
                })
                .catch(error => {
                    this.isEdit = false
                    this.body = this.data.body
                    this.title = this.data.title

                    window.flash(error.response.data.message, 'red')
                })
        },
    }
}
</script>

<style lang="scss" scoped>

</style>