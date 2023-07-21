<template>
    <div class="modal fade" id="modal-post-show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-w-auto" role="document">
            <div class="modal-content overflow-hidden border-0">
                <button type="button" @click="$emit('close-modal')" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body p-0">
                    <div class="post-show-data">
                        <PostShow :user="user" :post="post" ></PostShow>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PostShow from "../PostShow";
export default {
    components : {PostShow},
    name: "ModalComments",
    props : ['post','user'],
}
</script>

<style scoped>
    .post-show-data{
        max-height: 80vh;
        overflow-y: auto;
    }
    .post-show-data::-webkit-scrollbar{
        display: none;
    }
    .modal-w-auto{
        max-width: fit-content !important;
    }
</style>
