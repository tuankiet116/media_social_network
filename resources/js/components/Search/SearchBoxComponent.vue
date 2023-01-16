<template>
    <div class="box m-0 p-1" v-if="keywords">
        <div v-for="r in results" class="content p-2 m-1" style="background-color:#f2f2f2;cursor:pointer">
            <template v-if="r.result_id && r.result_type">
                <router-link v-if="r.result_type == 'COMMUNITY'" :to="{ name: 'community_page', params: { id: r.result_id }}" @click="$emit('redirectSearch')">
                    <span>
                        "{{ keywords }}"
                    </span>
                </router-link>
                <router-link v-if="r.result_type == 'USER'" :to="{ name: 'profile_list_post', params: { id: r.result_id }}" @click="$emit('redirectSearch')">
                    <span>
                        "{{ keywords }}"
                    </span>
                </router-link>
            </template>
            <router-link v-else :to="{ name: 'search_page', params: { keyword: r.keyword }}">
                <span>
                    <i class="fa-regular fa-clock"></i>
                    "{{ r.keyword }}"
                </span>
            </router-link>
        </div>
        <div class="content p-2 m-1" style="background-color:#f2f2f2;cursor:pointer" @click="search">
            <router-link :to="{ name: 'search_page', params: { keyword: keywords }}" @click="$emit('redirectSearch')">
                <span>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Searching for "{{ keywords }}"
                </span>
            </router-link>
        </div>
    </div>
</template>
<script>
import { searchHistory } from '../../api/search';
export default {
    props: ['keywords'],
    data() {
        return {
            results: []
        }
    },
    watch: {
        async keywords() {
            await this.searchHistory();
        }
    },
    mounted() {
        this.searchHistory();
    },
    methods: {
        async searchHistory() {
            await searchHistory(this.keywords ?? "").then((result) => {
                this.results = result.data;
            });
        }
    }
}
</script>