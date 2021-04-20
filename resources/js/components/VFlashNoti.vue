<template>
    <div v-if="show" :class="'border-'+level+'-400 text-'+level+'-500'" class="bg-white border-2 shadow-lg rounded-lg fixed top-2 inset-x-1/3 py-2 px-3" role="alert">
        <div class="text-center" v-text="body">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data(){
            return {
                body: this.message,
                level: 'green',
                show: false
            }
        },

        created(){
            if(this.message){
                this.flash();
            }

            window.events.$on('flash' , data => this.flash(data) );
        },

        methods: {
            flash(data){
                if(data){
                    this.body = data.message;
                    this.level = data.level;
                }

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
