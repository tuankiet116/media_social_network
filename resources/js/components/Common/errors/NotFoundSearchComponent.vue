<template>
    <div style="width: 100%;" class="is-flex is-justify-content-center is-align-items-center">
        <figure class="image">
            <img src="../../../../images/gifs/not_found.gif"/>
        </figure>
        <div class="content is-justify-content-center is-align-items-center" style="display: flex">
            <h3>{{ $t('error.no_result_match') }}</h3>
        </div>
    </div>
</template>
<style scoped>
    .image {
        width: 200px;
    }
</style>