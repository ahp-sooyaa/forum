<template>
    <transition name="slide-fade">
        <div v-if="show" :class="[status == 'red' ? 'bg-red-500' : 'bg-green-500']" class="text-white shadow-lg rounded-lg fixed top-2 inset-x-1/3 py-2 px-3" role="alert">
            <div class="text-center transition ease-in-out duration-500 transform -translate-y-1 scale-110" v-text="body">
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: ['message'],

        data(){
            return {
                body: this.message,
                status: 'green',
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
                    this.status = data.status;
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

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all .5s;
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateY(-100px);
  opacity: 0;
}
</style>