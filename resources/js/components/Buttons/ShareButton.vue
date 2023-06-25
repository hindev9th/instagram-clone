<template>
    <div>
        <span class="btn-share" @click="showAndHide"><i class="far fa-paper-plane ml-2"></i></span>
        <div v-if="isShow">
            <share-post :text-link="textLink" @close-modal="showAndHide"></share-post>
        </div>
    </div>
</template>
<script>
    import SharePost from "../Modals/SharePost";
    export default {
        components: {SharePost},
        props : ['textLink'],
        data(){
            return {
                isShow : false,
            }
        },
        methods : {
            showAndHide(){
                this.isShow = !this.isShow;
            }
        }
    }
</script>

<style>
    .btn-share{
        cursor: pointer;
    }
    .btn-share i{
        color: #212529;
        font-size: 25px;
    }
</style>
