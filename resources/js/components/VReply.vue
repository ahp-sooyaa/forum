<template>
    <div :id="'reply-'+data.id" class="flex bg-gray-800 p-5 mb-3 rounded-2xl text-white">
        <img class="rounded-xl mr-3 w-16 h-16" :src="'https://gravatar.com/avatar/'+data.owner.email+'?s=60'" :alt="data.owner.name">
        <div>
            <div class="mb-3">
                <h3 class="font-semibold">
                    <a class="text-white text-base" :href="'profiles/'+data.owner.name">{{data.owner.name}}</a>
                    <span v-if="isOp" class="bg-indigo-500 inline-block rounded-xl px-2 text-sm">
                        op
                    </span>
                </h3>
                <div class="text-gray-400 text-xs">Posted {{ date }}</div>
            </div>

            <textarea v-if="isEdit" class="text-area text-sm text-gray-700 mb-2" v-model="data.body" rows="5"></textarea>

            <p v-else class="mb-2 text-sm" v-text="data.body"></p>

            <div class="flex">

                <v-favorite v-if="signIn" :data="this.data"></v-favorite>

                <div v-if="canUpdate">
                    <div v-if="isEdit" class="h-full">
                        <button @click="update" class="h-full text-xs font-semibold border-2 bg-gray-500 hover:border-gray-500 border-gray-600 rounded-xl inline-block px-2 md:px-3 ml-2">
                            Update
                        </button>
                        <button @click="isEdit = false" class="h-full text-xs font-semibold border-2 bg-gray-500 hover:border-gray-500 border-gray-600 rounded-xl inline-block px-2 md:px-3 ml-2">
                            Cancel
                        </button>
                    </div>
                    <div v-else class="h-full">
                        <button @click="isEdit = true" class="h-full text-xs font-semibold border-2 bg-gray-500 hover:border-gray-500 border-gray-600 rounded-xl inline-block px-2 md:px-3 ml-2">
                            Edit
                        </button>
                        <button @click="destroy" class="h-full text-xs font-semibold border-2 bg-red-500 hover:border-red-500 border-red-600 rounded-xl inline-block px-2 md:px-3 ml-2">
                            Delete
                        </button>
                    </div>
                </div>

            </div>
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
                endPoint: `/replies/${this.data.id}`,
                isEdit: false,
            }
        },

        computed: {
            date() {
                return moment(this.data.created_at).fromNow()
            },
            signIn(){
                return window.App.signIn;
            },
            canUpdate(){
                if(window.App.user){
                    return this.data.owner.id == window.App.user.id;
                }
            },
            isOp(){
                return this.data.thread.creator.id == this.data.owner.id;
            }
        },

        methods: {
            update(){
                axios.patch(this.endPoint, {body: this.data.body})
                    .then(response => {
                        this.isEdit= false,
                        flash('Your reply has been updated!')
                    })
                    .catch(error => {
                        this.isEdit = false
                        flash(error.response.data, 'red')
                    })
            },
            destroy(){
                axios.delete(this.endPoint)
                .then(response => {
                    // $(this.$el).fadeOut(300)
                    this.$emit('destroyed', this.data.id)
                    flash('Your reply has been deleted!')
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>