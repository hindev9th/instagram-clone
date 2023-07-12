<template>
    <div class="setting">
        <span class="btn-setting" @click="showModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal-setting"> <i class="fas fa-ellipsis-h"></i></span>

        <div class="modal fade" v-if="isShow" id="modal-setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content overflow-hidden border-0">
                    <button type="button" @click="showModal" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body p-0">
                        <ul class="list-unstyled text-center m-0">
                            <li class="hover-dark-20 p-2 border-bottom font-weight-bold text-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal-confirm"  @click="showModalConfirm();"  >Delete</li>
                            <li class="hover-dark-20 p-2 border-bottom">Edit</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="gotoPost">Go to post</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="showModalShare" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal-share">Share to...</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="copyText">
                                Copy link
                                <input type="hidden" :value="textLink" id="link-copy">
                            </li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="aboutThisAccount">About this account</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="showModal" data-dismiss="modal">Cancel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" v-if="isShowConfirm" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content overflow-hidden border-0">
                    <div class="modal-header d-flex flex-column align-items-center">
                        <strong>Delete post?</strong>
                        <span>Are you sure you want to delete this post?</span>
                    </div>
                    <button type="button" @click="hideModalConfirm" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body p-0">
                        <ul class="list-unstyled text-center m-0">
                            <li class="hover-dark-20 p-2 border-bottom text-danger font-weight-bold" @click="deletePost">Delete</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="hideModalConfirm" data-dismiss="modal">Cancel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <ModalShare v-if="isShowShare" :text-link="textLink" @close-modal="hideModalShare"></ModalShare>
    </div>
</template>

<script>
    import $ from 'jquery';
    import ModalShare from "../Modals/ModalShare";
    import {showNotify} from "../../../functiton";
export default {
    components : {ModalShare},
    name: "SettingButton",
    props: ['post','textLink','profileLink'],
    data(){
        return{
            isShow : false,
            isShowShare : false,
            isShowConfirm : false,
            postData : JSON.parse(this.post),
        }
    },
    methods: {
        showNotify,
        showModal() {
            this.isShow = !this.isShow;
        },
        showModalConfirm() {
            $('#modal-setting').modal('hide');

            this.isShowConfirm = !this.isShowConfirm;
            $('#modal-confirm').modal('show');
        },
        hideModalConfirm(){
            this.isShowConfirm = !this.isShowConfirm;
            this.isShow = !this.isShow;
        },
        showModalShare() {
            $('#modal-setting').modal('hide');

            this.isShowShare = !this.isShowShare;
            $('#modal-share').modal('show');
        },
        hideModalShare(){
            this.isShowShare = !this.isShowShare;
            this.isShow = !this.isShow;
        },
        copyText() {
            let testingCodeToCopy = document.querySelector('#link-copy')
            testingCodeToCopy.setAttribute('type', 'text')
            testingCodeToCopy.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                this.showNotify('Copy link ' + msg);
                this.isShow = !this.isShow;
                $('#modal-setting').modal('hide');
            } catch (err) {
                this.showNotify('Oops, unable to copy');
                this.isShow = !this.isShow;
                $('#modal-setting').modal('hide');
            }
            testingCodeToCopy.setAttribute('type', 'hidden')
        },
        gotoPost(){
            window.location = this.textLink;
        },
        aboutThisAccount(){
            window.location = this.profileLink;
        },
        deletePost(){
            axios.delete(window.Laravel.baseUrl + '/p/d/' + this.postData.id)
            .then(response => {
                console.log(response.data)
                this.hideModalConfirm();
                $('#modal-confirm').modal('hide');
                this.showNotify('Delete post success.');
            })
            .catch(error => {
                console.log('error')
                this.showNotify('Error! cannot delete post.');
            })
        }
    },
}
</script>

<style>
    .setting{
        position: absolute;
        right: 20px;
        display: flex;
        align-items: center;
        height: 100%;
    }
    .btn-setting{
        cursor: pointer;
    }

    .modal-content .close{
        top: 20px;
        right: 20px;
        font-size: 50px;
        color: #000;
        &:hover{
             color: #f3f3f3;
         }
    }
    .modal.fade .modal-dialog{
        transform: none;
        .modal-content{
            border-radius: 12px;
        }
    }
    .modal-body ul li{
        cursor: pointer;
         &:last-child{
        border: unset !important;
          }
    }

</style>
