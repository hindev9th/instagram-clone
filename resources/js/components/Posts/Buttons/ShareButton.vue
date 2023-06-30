<template>
    <div>
        <span class="btn-share" @click="showAndHide"><i class="far fa-paper-plane ml-2"></i></span>
        <transition name="fade" mode="out-in">
        <div v-if="isShow">
            <ModalShare :text-link="textLink" @close-modal="showAndHide"></ModalShare>
        </div>
        </transition>
    </div>
</template>
<script>
    import ModalShare from "../Modals/ModalShare.vue";
    export default {
        components: {ModalShare},
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
