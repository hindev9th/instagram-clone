<template>
    <div class="modal-overlay">
        <div class="modal-custom">
            <div class="modal-custom-header border-bottom pt-3 pb-3">
                <strong>Share to</strong>
                <span class="modal-custom-close" @click="$emit('close-modal')"><i class="fa fa-times"></i></span>
            </div>
            <div class="list-items d-flex flex-column align-items-start">
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="shareFacebook">
                    <i class="fab fa-facebook icon"></i>
                    <span>Facebook</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4">
                    <i class="fas fa-qrcode icon"></i>
                    <span>QR Code</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="copyText">
                    <i class="fas fa-link icon"></i>
                    <span>Copy Link</span>
                    <input type="hidden" v-model="textLink" id="link-copy">
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="$emit('close-modal')">
                    <i class="fa fa-times icon"></i>
                    <span>Cancel</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['textLink'],
        data(){
            return{
                isShowQR : false,
            }
        },
        methods : {
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
            shareFacebook(){
                window.open("https://www.facebook.com/sharer/sharer.php?u="+this.textLink,"_blank");
            }
        }
    }
</script>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        background-color: #000000da;
        z-index: 1000;
    }

    .modal-custom {
        text-align: center;
        background-color: white;
        max-height: 400px;
        min-width: 400px;
        margin-top: 10%;
        border-radius: 20px;
        overflow: auto;
    }
    .modal-custom .modal-custom-header{
        position: relative;
    }
    .modal-custom-close {
        position: absolute;
        right: 15px;
        top: 5px;
        font-size: 30px;
        cursor: pointer;
    }

    .list-items{
        font-size: 16px;
        text-align: start;
    }
    .list-items .item{
        width: 100%;
        cursor: pointer;
    }
    .list-items .item .icon{
        width: 25px;
    }
    .list-items .item:hover{
        background-color: #f3f3f3;
    }

</style>
