<template>
    <div class="is-hidden-desktop">
        <div class="container is-flex">
            <div class="is-flex m-1 is-align-items-center justify-content-center">
                <p class="label">Filter:</p>
            </div>
            <div class="button m-1">
                All
            </div>
            <div class="button m-1">
                Post
            </div>
            <div class="button m-1">
                User
            </div>
            <div class="button m-1">
                Community
            </div>
            <div class="button m-1">
                Community
            </div>
        </div>
        <div>
            <router-view></router-view>
        </div>
    </div>
    <div class="columns mt-2 is-hidden-mobile" style="width: 100%">
        <div class="column is-2">
            <div style="position:sticky; top: 6rem">
                <div class="box m-1">
                    All
                </div>
                <div class="box m-1">
                    Post
                </div>
                <div class="box m-1">
                    User
                </div>
                <div class="box m-1">
                    Community
                </div>
            </div>
        </div>
        <div class="column">
            <router-view></router-view>
        </div>
    </div>
</template>
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
</style>