<template>
    <div class="modal-overlay">
        <div class="modal-custom">
            <span class="close-button" @click="$emit('close-modal')"><i class="fa fa-times"></i></span>
            <div class="list-items center-modal-list font-weight-normal d-flex flex-column align-items-start">
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="deletePost">
                    <span class="text-danger">Delete</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="editPost">
                    <span>Edit</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="goToPost">
                    <span>Go to post</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="sharePost">
                    <span>Share to...</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="copyText">
                    <span>Copy link</span>
                    <input type="hidden" v-model="textLink" id="link-copy">
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="aboutAccount">
                    <span>About this account</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="$emit('close-modal')">
                    <span>Cancel</span>
                </div>
            </div>
        </div>
        <transition name="fade" mode="out-in">
            <ModalDelete :post_id="1" v-if="isShowDelete" @close-modal="deletePost"></ModalDelete>
        </transition>
    </div>
</template>

<script>
    import ModalDelete from "./ModalDelete.vue";

export default {
    components : {ModalDelete},
    name: "ModalSetting",
    props : ['textLink'],
    data(){
        return{
            isShowDelete: false,
        }
    },
    methods : {
        deletePost(){
            this.isShowDelete = !this.isShowDelete;
        },
        editPost(){

        },
        goToPost(){

        },
        aboutAccount(){

        },
        copyText() {
            let testingCodeToCopy = document.querySelector('#link-copy')
            testingCodeToCopy.setAttribute('type', 'text')
            testingCodeToCopy.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                alert('Copy link ' + msg);
            } catch (err) {
                alert('Oops, unable to copy');
            }
            testingCodeToCopy.setAttribute('type', 'hidden')
        },
        sharePost(){

        }
    }
}
</script>

<style >
    .modal-custom .center-modal-list{
        text-align: center;
    }
    .modal-custom .item{
        border-bottom: 1px solid #dee2e6 ;
    }
    .modal-custom .close-button{
        cursor: pointer;
        position: fixed;
        top: 50px;
        right: 50px;
        color: #fff;
        font-size: 20px;
        z-index: 10;
    }
</style>
