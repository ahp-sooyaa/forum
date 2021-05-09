<template>
  <ais-instant-search
    v-cloak
    :search-client="searchClient"
    index-name="threads"
    class="flex min-h-screen mt-6"
  >
    <ais-panel class="card mr-5 rounded-2xl p-4 h-full w-1/5">
        <ais-search-box autofocus v-model="q" class="mb-2"/>
        <ais-powered-by class="mb-4"/>

        <ais-state-results>
            <p :class="!hits.length ? 'hidden' : ''" slot-scope="{ state: { query }, results: { hits } }">
                <h5 class="mt-4 mb-2 font-bold tracking-wider text-xl">Channels</h5>
            </p>
        </ais-state-results>
        
        <ais-refinement-list 
            attribute="channel.name" 
            :limit='5'
            show-more
            :sort-by="['name:asc']"
        >
            <div slot="showMoreLabel" slot-scope="{ isShowingMore }">
                <span v-if="!isShowingMore" class="flex text-blue-500 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    View More
                </span>
                <div v-else class="flex text-blue-500 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    View Less
                </div>
            </div>
        </ais-refinement-list>
    </ais-panel>

    <div class="w-4/5">
        <div class="flex">
            <ais-current-refinements />

            <ais-clear-refinements class="flex-shrink-0">
                <span slot="resetLabel">
                    Clear All
                </span>
            </ais-clear-refinements>
        </div>

        <ais-state-results>
          <p
            slot-scope="{ state: { query }, results: { hits } }"
            v-show="!hits.length"
          >
            No matches for your search. Sorry!
          </p>
        </ais-state-results>
        <ais-hits>
            <ul class="ais-Hits-list" slot-scope="{ items, sendEvent }">
                <li class="ais-Hits-item flex items-start" v-for="item in items" :key="item.objectID">
                    <a :href="'/profiles/'+item.creator.name" class="md:mr-5 flex items-center">
                        <img class="flex-shrink-0 order-first rounded-xl w-16 h-16" :src="'https://gravatar.com/avatar/'+md5(item.creator.email)+'?s=128'" :alt="item.creator.name+'s avatar'">
                        <span class="md:hidden text-gray-400 ml-3 font-bold">{{item.creator.name}}</span>
                    </a>
                    <div class="w-full">
                        <div class="flex justify-between">
                            <div class="flex">
                                <div v-for="date in moment(item.created_at).split(' ')">
                                    <div class="bg-white dark:bg-black rounded-lg p-2 mr-2 mb-2 text-black text-xs font-semibold shadow-md">{{date}}</div>
                                </div>
                            </div>
                            <div class="flex text-gray-400 rounded-full px-3 items-center">
                                <svg class="w-3 h-4 mb-1 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 10" fill="currentColor">
                                    <path d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"></path>
                                </svg>
                                {{item.replies_count}}
                            </div>
                        </div>
                    
                        <h1>
                            <a :href="item.path" class="text-black dark:text-white">
                                <ais-highlight class="hover:underline mb-3 block" attribute="title" :hit="item" />
                                <ais-highlight class="text-sm no-underline block text-black text-opacity-50 dark:text-white dark:text-opacity-50" attribute="body" :hit="item" />
                            </a>
                        </h1>
                    </div>
                </li>
            </ul>
        </ais-hits>
    </div>
  </ais-instant-search>
</template>

<script>
import md5 from 'md5'
import moment from 'moment'
import algoliasearch from 'algoliasearch/lite'

export default {
  data() {
    return {
      searchClient: algoliasearch(
        'DFCALV7TGN',
        'eb5b50406ef21c7dd8cb68e0326f73b6'
      ),
      q: ''
    };
  },
  created() {
      let query = location.search.match(/q=(\w+)/)

      this.q = query ? query[1] : ''
  },
  methods: {
      moment(date){
          return moment(date).format("MMMM DD");
      },
      md5(value){
          return md5(value)
      }
  }
};
</script>

<style scoped>
[v-cloak] {
    display: none;
}

.ais-Panel {
    min-width: 275px;
}
</style>
