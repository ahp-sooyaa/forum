<template>
    <div 
        :id="'reply-'+data.id" 
        class="relative flex p-5 mb-3 rounded-2xl bg-gray-700 hover:bg-gray-800 border-2 text-white" 
        :class="isBest ? 'border-indigo-400' : 'border-gray-800'"
    >
        <img class="rounded-xl mr-3 w-16 h-16" :src="'https://gravatar.com/avatar/'+data.owner.email+'?s=60'" :alt="data.owner.name">
        <div class="w-full">
            <div class="mb-3">
                <h3 class="font-semibold">
                    <a 
                        class="text-base text-white" :href="'profiles/'+data.owner.name"
                    >
                        {{data.owner.name}}
                    </a>
                    <span v-if="isOp" class="bg-white text-black rounded-xl px-2 text-sm">
                        op
                    </span>
                </h3>
                <div class="text-gray-400 text-xs">Posted {{ date }}</div>
            </div>

            <div v-if="isEdit">
                <textarea 
                    class="text-area w-full text-sm text-gray-700 mb-2" 
                    v-model="body" rows="5"
                ></textarea>
                <div class="flex">
                    <v-favorite v-if="$signIn" :data="this.data"></v-favorite>
                    <button @click="update" class="text-xs font-semibold border bg-gray-800 border-gray-500 hover:border-gray-400 text-gray-400 rounded-xl inline-block px-2 md:px-3 ml-2">
                        Update
                    </button>
                    <button @click="()=>{isEdit = false ,body=this.data.body}" class="text-xs font-semibold border bg-red-700 text-red-300 border-red-500 hover:border-red-400 rounded-xl inline-block px-2 md:px-3 ml-2">
                        Cancel
                    </button>
                </div>
            </div>

            <div v-else> 
                <p class="mb-2 text-sm" v-html="body"></p>
                <div class="flex">
                    <v-favorite v-if="$signIn" :data="this.data"></v-favorite>
                    <div v-if="authorize('owns', reply)">
                        <!-- bg-gray-200 hover:border-gray-400 border-gray-300 for light theme -->
                        <button @click="isEdit = true" class="h-full text-xs font-semibold bg-gray-800 border-gray-500 text-gray-400 hover:border-gray-400 border rounded-xl inline-block px-2 md:px-3 ml-2">
                            Edit
                        </button>
                        <button @click="destroy" class="h-full text-xs font-semibold bg-red-500 text-white border border-red-300 hover:border-red-200 rounded-xl inline-block px-2 md:px-3 ml-2">
                            Delete
                        </button>
                    </div>
                    <button v-show="!isBest && authorize('owns', reply.thread)" 
                        @click="markBestReply" 
                        class="justify-self-end text-xs font-semibold hover:border-gray-400 border rounded-xl inline-block px-2 md:px-3 ml-auto"
                    >
                        Best?
                    </button>
                </div>
            </div>
        </div>
        <div v-show="isBest"
            class="absolute right-5 py-1 text-xs font-semibold bg-indigo-500 rounded-xl inline-block px-2 md:px-3 ml-auto"
        >
            Best Reply
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import VFavorite from './VFavorite'

    export default {
        props: ['data'],

        components: {VFavorite},
        
        data(){
            return {
                body: this.data.body,
                endPoint: `/replies/${this.data.id}`,
                isEdit: false,
                isBest: this.data.isBest,
                reply: this.data
            }
        },

        computed: {
            date() {
                return moment(this.data.created_at).fromNow()
            },
            isOp(){
                return this.data.thread.creator.id == this.data.owner.id;
            }
        },

        created(){
            window.events.$on('markedBestReply', id => {
                this.isBest = (id == this.data.id)
            })
        },

        methods: {
            update(){
                axios.patch(this.endPoint, {body: this.body})
                    .then(response => {
                        this.isEdit= false,
                        this.data.body = this.body

                        flash('Your reply has been updated!')
                    })
                    .catch(error => {
                        this.isEdit = false
                        this.body = this.data.body

                        flash(error.response.data.message, 'red')
                    })
            },
            destroy(){
                axios.delete(this.endPoint)

                this.$emit('destroyed', this.data.id)
                flash('Your reply has been deleted!')
            },
            markBestReply(){
                this.isBest = true

                window.events.$emit('markedBestReply', this.data.id)

                axios.post(this.endPoint+'/best');
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>