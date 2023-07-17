<template>
    <div class="setting">
        <span class="btn-setting" @click="showModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" :data-target="`#modal-setting-${post.id}`"> <i class="fas fa-ellipsis-h"></i></span>

        <div class="modal fade" v-if="" :id="`modal-setting-${post.id}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content overflow-hidden border-0">
                    <button type="button" @click="showModal" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body p-0">
                        <ul class="list-unstyled text-center m-0">
                            <li class="hover-dark-20 p-2 border-bottom font-weight-bold text-danger"
                                v-show="post.user_id === user.id" data-toggle="modal" data-backdrop="static"
                                data-keyboard="false" :data-target="`#modal-confirm-${post.id}`" @click="showModalConfirm();">Delete
                            </li>
                            <li class="hover-dark-20 p-2 border-bottom" v-if="post.user_id === user.id">Edit</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="gotoPost">Go to post</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="showModalShare" data-toggle="modal"
                                data-backdrop="static" data-keyboard="false" :data-target="`#modal-share-${post.id}`">Share to...
                            </li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="copyText">
                                Copy link
                                <input type="hidden" :value="baseUrl + '/p/' + post.id" id="link-copy">
                            </li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="aboutThisAccount">About this account
                            </li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="showModal" data-dismiss="modal">Cancel
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" v-if="isShowConfirm" :id="`modal-confirm-${post.id}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <ModalShare v-if="isShowShare" :post="post" @close-modal="hideModalShare"></ModalShare>
    </div>
</template>

<script>
    import $ from 'jquery';
    import ModalShare from "../Modals/ModalShare";
    import {showNotify} from "../../../functiton";
export default {
    components : {ModalShare},
    name: "SettingButton",
    props: ['post','user'],
    data(){
        return{
            isShow : false,
            isShowShare : false,
            isShowConfirm : false,
            baseUrl : window.Laravel.baseUrl,
        }
    },
    methods: {
        showNotify,
        showModal() {
            this.isShow = !this.isShow;
        },
        showModalConfirm() {
            $('#modal-setting-'+this.post.id).modal('hide');

            this.isShowConfirm = !this.isShowConfirm;
            $('#modal-confirm-'+this.post.id).modal('show');
        },
        hideModalConfirm(){
            this.isShowConfirm = !this.isShowConfirm;
            this.isShow = !this.isShow;
        },
        showModalShare() {
            $('#modal-setting-'+this.post.id).modal('hide');

            this.isShowShare = !this.isShowShare;
            $('#modal-share-'+this.post.id).modal('show');
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
                $('#modal-setting-'+this.post.id).modal('hide');
            } catch (err) {
                this.showNotify('Oops, unable to copy');
                this.isShow = !this.isShow;
                $('#modal-setting-'+this.post.id).modal('hide');
            }
            testingCodeToCopy.setAttribute('type', 'hidden')
        },
        gotoPost(){
            window.location = this.baseUrl + '/p/' + this.post.id;
        },
        aboutThisAccount(){
            window.location = this.baseUrl + '/profile/' + this.post.user.username;
        },
        deletePost(){
            axios.delete(window.Laravel.baseUrl + '/p/' + this.post.id)
            .then(response => {
                Bus.$emit('delete-post',this.post);
                this.hideModalConfirm();
                $('#modal-confirm-'+this.post.id).modal('hide');
                $('.modal-backdrop').remove();
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
        padding-right: 5px;
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
    @media (max-width: 479px) {
        .setting{
            padding-right: 20px;
        }
    }
</style>
