<template>
    <li class="" @click="showAndHideSearch">
        <i class="fa fa-search icon"></i>
        <span class="item-text">Search</span>
    </li>
</template>

<script>
import $ from 'jquery';
export default {
    name: "SearchButton",
    methods:{
        showAndHideSearch(){
            $('.search-slide').toggleClass('show');
            $('.menu-app:not(.message)').toggleClass('small');
        }
    }
}
</script>

<style scoped>

</style>
