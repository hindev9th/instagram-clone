<template>
    <div class="modal-share-post">
        <div class="modal fade" :id="`modal-share-${post.id}`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content overflow-hidden border-0">
                    <div class="modal-header d-flex justify-content-center position-relative">
                        <strong class="title">Share to...</strong>
                        <button type="button" @click="$emit('close-modal')" class="close position-absolute" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <ul class="list-unstyled text-left m-0">
                            <li class="hover-dark-20 p-2" @click="shareFacebook">
                                <i class="fab fa-facebook icon"></i>
                                Facebook
                            </li>
                            <li class="hover-dark-20 p-2" @click="showModalQrCode" data-toggle="modal" data-keyboard="false" :data-target="`#modal-qr-code-${post.id}`">
                                <i class="fas fa-qrcode icon"></i>
                                QR Code
                            </li>
                            <li class="hover-dark-20 p-2" @click="copyText">
                                <i class="fas fa-link icon"></i>
                                Copy link
                                <input type="hidden" :value="`${base_url}/p/${post.id}`" :id="`link-copy-${post.id}`">
                            </li>
                            <li class="hover-dark-20 p-2 btn-close-modal-share" @click="$emit('close-modal')" data-dismiss="modal">
                                <i class="fa fa-times icon"></i>
                                Cancel
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <ModalQRCode v-if="isShowQR" :post="post" @close-modal="hideModalQrCode"></ModalQRCode>
    </div>

</template>

<script>
    import $ from 'jquery';
    import {showNotify} from "../../../functiton";
    import ModalQRCode from "./ModalQRCode";
    export default {
        components: {ModalQRCode},
        props : ['post'],
        data(){
            return{
                isShowQR : false,
                base_url: window.Laravel.baseUrl,
            }
        },
        methods : {
            showNotify,
            copyText() {
                let testingCodeToCopy = document.querySelector(`#link-copy-${this.post.id}`)
                testingCodeToCopy.setAttribute('type', 'text')
                testingCodeToCopy.select()

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    this.showNotify('Copy link ' + msg);
                    $(`#modal-share-${this.post.id}`).modal('hide');
                } catch (err) {
                    this.showNotify('Oops, unable to copy');
                    $(`#modal-share-${this.post.id}`).modal('hide');
                }
                testingCodeToCopy.setAttribute('type', 'hidden')
            },
            shareFacebook(){
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${this.base_url}/p/${this.post.id}`,"_blank");
            },
            hideModalQrCode(){
                this.isShowQR = false;
                this.$emit('close-modal');
            },
            showModalQrCode(){
                this.isShowQR = true;
                $(`#modal-share-${this.post.id}`).modal('hide');
            }
        }
    }
</script>

<style scoped>
    .title{
        font-size: 18px;
    }
    li{
        font-size: 18px;
    }
    .icon{
        text-align: center;
        width: 25px;
    }
</style>
