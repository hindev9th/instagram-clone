<template>
    <div>
        <span class="btn-comment prevent-select cursor-pointer" @click="showAndHide" data-toggle="modal" data-backdrop="static" data-keyboard="false"
              data-target="#modal-post-show" v-html="showText"></span>
        <ModalPostShow :post="post" :user="user" v-if="isShow" @close-modal="showAndHide"></ModalPostShow>
    </div>
</template>

<script>
import ModalPostShow from "../Modals/ModalPostShow";
export default {
    components : {ModalPostShow},
    name: "CommentButton",
    props: ['post','user','text'],
    data(){
        return{
            isShow : false,
        }
    },
    methods : {
        showAndHide(){
            this.isShow = !this.isShow;
        },
    },
    computed:{
        showText(){
            return this.text !== '' ? this.text : '<i class="far fa-comment ml-2" style="font-size: 25px"></i>';
        }
    }
}
</script>

<style scoped>
    .btn-comment i{
        color: #212529;
        font-size: 25px;
    }
</style>
