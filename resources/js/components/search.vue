<template>
  <ais-instant-search
    :search-client="searchClient"
    index-name="threads"
    class="flex"
  >
    <ais-panel>
        <ais-search-box autofocus show-loading-indicator v-model="q"/>

        <h5 class="font-weight-bold">
            <i class="fas fa-signature"></i> Channels
        </h5>
        <ais-refinement-list 
            attribute="channel.name" 
            :limit='5'
            show-more
            :sort-by="['name:asc']"
        />
    </ais-panel>

    <div>
        <div class="flex">
            <ais-clear-refinements />
            <ais-current-refinements />
        </div>
        <ais-hits-per-page
          :items="[
            { label: '8 hits per page', value: 8, default: true },
            { label: '16 hits per page', value: 16 },
          ]"
        />
        <ais-hits>
            <ul slot-scope="{ items, sendEvent }">
                <li v-for="item in items" :key="item.objectID">
                    <h1>
                        <a :href="item.path" class="text-black">
                            <ais-highlight class="hover:underline" attribute="title" :hit="item" />
                            <ais-highlight class="text-sm no-underline block" attribute="body" :hit="item" />
                        </a>
                    </h1>
                </li>
            </ul>
        </ais-hits>
    </div>
  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite';

export default {
  data() {
    return {
      searchClient: algoliasearch(
        'DFCALV7TGN',
        'eb5b50406ef21c7dd8cb68e0326f73b6'
      ),
      q: location.search.match(/q=(\w+)/)[1]
    };
  },
};
</script>
