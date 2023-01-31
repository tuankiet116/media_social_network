<template>
    <div class="is-hidden-desktop">
        <div class="container is-flex">
            <div class="is-flex m-1 is-align-items-center justify-content-center">
                <p class="label">{{ $t('search_page.filter') }}:</p>
            </div>
            <router-link :to="{ name: 'search_page', params: { keyword: keyword } }"
                :class="{ 'active': isCurrent('search_page') }" class="button m-1">
                {{ $t('search_page.all') }}
            </router-link>
            <router-link :to="{ name: 'search_post', params: { keyword: keyword } }"
                :class="{ 'active': isCurrent('search_post') }" class="button m-1">
                {{ $t('search_page.post') }}
            </router-link>
            <router-link :to="{ name: 'search_user', params: { keyword: keyword } }"
                :class="{ 'active': isCurrent('search_user') }" class="button m-1">
                {{ $t('search_page.user') }}
            </router-link>
            <router-link :to="{ name: 'search_community', params: { keyword: keyword } }"
                :class="{
                'active': isCurrent('search_community')}" class="button m-1">
                {{ $t('search_page.community') }}
            </router-link>
        </div>
        <div>
            <router-view></router-view>
        </div>
    </div>
    <div class="columns mt-2 is-hidden-mobile" style="width: 100%">
        <div class="column is-2">
            <div style="position:sticky; top: 6rem">
                <router-link :to="{ name: 'search_page', params: { keyword: keyword } }"
                    :class="{ 'active': isCurrent('search_page') }" class="box m-1">
                    {{ $t('search_page.all') }}
                </router-link>
                <router-link :to="{ name: 'search_post', params: { keyword: keyword } }"
                    :class="{ 'active': isCurrent('search_post') }" class="box m-1">
                    {{ $t('search_page.post') }}
                </router-link>
                <router-link :to="{ name: 'search_user', params: { keyword: keyword } }"
                    :class="{ 'active': isCurrent('search_user') }" class="box m-1">
                    {{ $t('search_page.user') }}
                </router-link>
                <router-link :to="{ name: 'search_community', params: { keyword: keyword } }"
                    :class="{ 'active': isCurrent('search_community') }" class="box m-1">
                    {{ $t('search_page.community') }}
                </router-link>
            </div>
        </div>
        <div class="column">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            keyword: this.$route.params.keyword
        }
    },
    methods: {
        isCurrent(name) {
            return this.$route.name == name;
        }
    }
}
</script>
<style scoped>
.box {
    background-color: whitesmoke;
}

.is-hidden-desktop {
    width: 100%;
    overflow: auto;
}

.container {
    position: sticky;
    width: max-content;
}

.active {
    background-color: #6b7b85;
    color: white;
}
</style>