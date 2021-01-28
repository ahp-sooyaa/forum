<template>
    <nav v-if="shouldPaginate" class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
        <a v-show="prevUrl" @click.prevent="page--" href="#" rel="prev" :class="onlyPrev" class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
          <!-- Heroicon name: chevron-left -->
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
          <span>Previous</span>
        </a>
        
        <a v-show="nextUrl" @click.prevent="page++" href="#" rel="next" :class="onlyNext" class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
          <span>Next</span>
          <!-- Heroicon name: chevron-right -->
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
        </a>
    </nav>
</template>

<script>
    export default {
        props: ['dataSet'],

        data(){
            return{
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        computed: {
            shouldPaginate(){
                return this.prevUrl || this.nextUrl
            },
            onlyNext(){
                return this.prevUrl ? 'rounded-r-md' : 'rounded-md'
            },
            onlyPrev(){
                return this.nextUrl ? 'rounded-l-md' : 'rounded-md'
            }
        },

        watch: {
            dataSet(){
                this.page = this.dataSet.current_page
                this.prevUrl = this.dataSet.prev_page_url
                this.nextUrl = this.dataSet.next_page_url
            },

            page(){
                this.broadcast().updateUrl()
            }
        },

        methods: {
            broadcast(){
                return this.$emit('updated', this.page)
            },

            updateUrl(){
                history.pushState(null, null, '?page=' + this.page)
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>