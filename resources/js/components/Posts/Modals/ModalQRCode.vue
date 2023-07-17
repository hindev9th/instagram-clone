<template>
    <div class="modal fade" :id="`modal-qr-code-${post.id}`" @click="$emit('close-modal')" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content overflow-hidden border-0">
                <button type="button" @click="$emit('close-modal')" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body p-0">
                    <div :id="`qr-code-${post.id}`" class="qr-code-post">
                        <img :src="imgQRCode" class="w-100 h-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
 export default {
     name: 'ModalQRCode',
     props: ['post'],
     data(){
         return{
             imgQRCode : null,
             base_url : window.Laravel.baseUrl,
         }
     },
     created() {
         this.fetchQRCode();
     },
     methods:{
         fetchQRCode(){
             const QRCode = require('qrcode-generator');

             const qrCode = QRCode(0, 'L');
             qrCode.addData(`${this.base_url}/p/${this.post.id}`);
             qrCode.make();

             const qrCodeData = qrCode.createDataURL(15);
             this.imgQRCode = qrCodeData;
             console.log(qrCodeData);
         }
     }
 }
</script>

<style>
    .qr-code-post{
        max-width: 500px;
        height: 500px;
    }
</style>
