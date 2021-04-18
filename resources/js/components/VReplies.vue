<template>
    <div>
        <div v-for="(reply, index) in replies" :key="reply.id">
            <v-reply :data="reply" @destroyed="remove(index)"></v-reply>
        </div>

        <v-new-reply @addedReply="add"/>

        <v-paginator :dataSet="dataSet" @updated="fetch"></v-paginator>
    </div>
</template>

<script>
    import VReply from './VReply.vue'
    import VNewReply from './VNewReply.vue'
    import collection from '../mixins/collection'
    import VPaginator from './VPaginator.vue'

    export default {
        components: { VReply, VNewReply, VPaginator},

        mixins: [ collection ],

        data(){
            return {
                dataSet: false,
                replies: [],
                endPoint: `${location.pathname}/replies?page=`
            }
        },

        created() {
            this.fetch()
        },

        methods: {
            fetch(page){
                if(! page){
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : '1'
                }
                axios.get(this.endPoint + page)
                    .then(response => {
                        this.dataSet = response.data
                        this.replies = response.data.data
                    })
            },
            // remove(index){
            //     // this.replies.splice(this.replies.findIndex(reply => reply.id == id), 1)
            //     this.replies.splice(index, 1)
            //     this.$emit('deleted')
            // },
            // add(reply){
            //     this.replies.push(reply)
            //     this.$emit('created')
            // }
        }
    }
</script>

<style lang="scss" scoped>

</style>