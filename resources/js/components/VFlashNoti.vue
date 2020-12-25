<template>
    <div v-if="show" class="bg-white border-2 border-indigo-400 shadow-lg rounded-lg fixed bottom-5 right-5 py-2 px-3 text-gray-500" role="alert">
        <div class="flex">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
            </svg>
            {{ body }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data(){
            return {
                body: '',
                show: false
            }
        },

        created(){
            if(this.message){
                this.flash(this.message);
            }

            window.events.$on('flash' , message => this.flash(message) );
        },

        methods: {
            flash(message){
                this.body = message;
                this.show = true;

                this.hide();
            },
             
            hide(){
                setTimeout(() => {
                    this.show = false
                }, 3000);
            }
        }
    }
</script>
