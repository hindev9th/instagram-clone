<template>
    <div>
        <span class="btn-share" @click="showAndHide" data-toggle="modal" data-backdrop="static" data-keyboard="false" :data-target="`#modal-share-${post.id}`"><i class="far fa-paper-plane ml-2"></i></span>
        <transition name="fade" mode="out-in">
        <div v-if="isShow">
            <ModalShare :post="post" @close-modal="showAndHide"></ModalShare>
        </div>
        </transition>
    </div>
</template>
<script>
    import ModalShare from "../Modals/ModalShare.vue";
    export default {
        components: {ModalShare},
        props : ['post'],
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
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s
    }

    .fade-enter,
    .fade-leave-to
        /* .fade-leave-active in <2.1.8 */

    {
        opacity: 0
    }
</style>
