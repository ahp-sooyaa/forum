<template>
    <div class="mb-3">
        <div v-if="signIn">
            <div v-if="isOpen" class="fixed w-3/5 mx-auto bg-gray-700 shadow-md p-5 rounded-t-3xl bottom-0 right-0 left-0">
                <div class="flex items-center text-white font-semibold mb-3">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    Reply to
                </div>
                <hr class="border border-gray-500">
                <div class="mb-3">
                    <textarea ref="textArea" name="body" rows="6" 
                        class="text-white border-0 focus:ring-0 block w-full sm:text-sm bg-gray-700 px-0" 
                        v-model="body"
                    ></textarea>
                </div>
                <button @click="addReply" class="btn-indigo text-sm">
                    Post
                </button>
                <button @click="isOpen = false" class="btn-outline-indigo text-sm">
                    Cancel
                </button>
            </div>
        </div>
        <div v-else class="text-center">
            Please <a href="/login">Login</a> to participate in forum discussion!
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                isOpen: false,
                body: '',
                endPoint: location.pathname + '/replies'
            }
        },

        created() {
            window.events.$on('reply', this.openModal)
        },

        computed: {
            signIn(){
                return window.App.signIn;
            }
        },

        methods: {
            addReply(){
                axios.post(this.endPoint, {body: this.body})
                    .catch(error => {
                        this.isOpen = false
                        this.body = ''

                        flash(error.response.data, 'red')
                    })
                    .then(({data}) => {
                        this.body = ''
                        this.isOpen = false

                        flash('Your reply has been posted!')

                        this.$emit('addedReply', data)
                    })
            },
            openModal(){
                this.isOpen = true
                this.$nextTick(() => this.$refs.textArea.focus())
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>