<template>
    <div 
        @mouseover="hover = true" @mouseleave="hover = false"
        :id="'reply-'+data.id" 
        class="relative flex p-5 mb-3 rounded-2xl card hover:bg-gray-50 dark:hover:bg-gray-500" 
        :class="isBest ? 'border-accent' : ''"
    >
        <img class="rounded-xl mr-3 w-16 h-16" :src="'https://gravatar.com/avatar/'+data.owner.email+'?s=128'" :alt="data.owner.name">
        <div class="w-full">
            <div class="mb-3">
                <div class="flex items-center">
                    <h3 class="font-semibold mr-2">
                        <a 
                            class="text-base text-black dark:text-white" :href="'/profiles/' + data.owner.name"
                        >
                            {{data.owner.name}}
                        </a>
                    </h3>
                    <div v-if="isOp" class="inline-block h-6 bg-white text-black dark:bg-black dark:text-white rounded-xl px-2 text-sm">
                        <span class="align-middle">op</span>
                    </div>
                </div>
                <div class="text-black text-opacity-50 dark:text-white dark:text-opacity-50 text-xs">Posted {{ date }}</div>
            </div>

            <!-- v-if doesn't work when component is mounted, so i used v-show -->
            <div v-show="isEdit">
                <textarea 
                    :id="'editBody-'+data.id" class="text-area w-full text-sm text-gray-700 mb-2" 
                    rows="5" v-model="body"
                ></textarea>
                <div class="flex">
                    <v-favorite v-if="$signIn" :data="this.data"></v-favorite>
                    <button @click="update" class="text-xs font-semibold bg-light-primary dark:bg-dark-primary border-gray-400 text-gray-400 border hover:border-gray-500 rounded-xl inline-block px-2 md:px-3 ml-2">
                        Update
                    </button>
                    <button @click="cancel" class="text-xs font-semibold text-red-500 rounded-xl inline-block px-2 md:px-3 ml-2">
                        Cancel
                    </button>
                </div>
            </div>

            <div v-show="!isEdit"> 
                <p class="mb-2 text-sm" v-html="reply.body"></p>
                <div class="flex">
                    <v-favorite v-if="$signIn" :data="this.data"></v-favorite>
                    <div v-if="authorize('owns', reply) && hover">
                        <!-- bg-gray-200 hover:border-gray-400 border-gray-300 for light theme -->
                        
                        <button @click="isEdit = true" class="border dark:border-gray-500 dark:hover:border-gray-100 dark:text-gray-300 font-semibold h-full hover:border-gray-500 inline-block md:px-3 ml-2 px-2 rounded-xl text-gray-700 text-xs">
                            Edit
                        </button>
                        <button @click="destroy" class="h-full text-xs font-semibold text-red-400 hover:text-red-500 rounded-xl inline-block px-2 md:px-3 ml-2">
                            Delete
                        </button>
                    </div>
                    <button v-show="!isBest && authorize('owns', reply.thread) && hover" 
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
    import Tribute from "tributejs";
    import moment from 'moment'
    import VFavorite from './VFavorite'

    export default {
        props: ['data'],

        components: {VFavorite},
        
        data(){
            return {
                body: '',
                hover: false,
                endPoint: `/replies/${this.data.id}`,
                isEdit: false,
                isBest: this.data.isBest,
                reply: this.data
            }
        },

        mounted() {
          let tribute = new Tribute({
            // column to search against in the object (accepts function or string)
            lookup: "value",
            // column that contains the content to insert by default
            fillAttr: "value",
            values: function (query, cb) {
              axios.get("/api/users", { params: { name: query } })
                .then(function (response) {
                  cb(response.data);
                });
            },
          });
          tribute.attach(document.getElementById(`editBody-${this.data.id}`));
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
            this.body = this.data.body.replace(/<\/?[^>]+>/ig, "")
        },

        methods: {
            update(){
                let formatBody = this.body.replace(/@([\w\-]+)/, "<a href='/profiles/$1'>@$1</a>")

                axios.patch(this.endPoint, {
                    body: formatBody
                })
                    .then(response => {
                        this.isEdit= false,
                        this.data.body = formatBody

                        flash('Your reply has been updated!')
                    })
                    .catch(error => {
                        this.isEdit = false
                        this.reply.body = this.data.body

                        flash(error.response.data.message, 'red')
                    })
            },
            cancel(){
                this.isEdit = false 
                this.body = this.data.body.replace(/<\/?[^>]+>/ig, "")
            },
            destroy(){
                axios.delete(this.endPoint)

                this.$emit('destroyed', this.data.id)
                flash('Your reply has been deleted!', 'red')
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