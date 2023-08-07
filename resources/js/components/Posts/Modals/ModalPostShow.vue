<template>
    <div class="modal fade" id="modal-post-show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-post-show" role="document">
            <div class="modal-content overflow-hidden border-0">
                <button type="button" @click="$emit('close-modal')" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body p-0">
                    <div class="post-show-data">
                        <PostShow :post="post" ></PostShow>
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
    props : ['post'],
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
    .modal-post-show{
        max-width: fit-content
    }
    @media (max-width: 767px) {
        .modal-post-show{
            margin: 1.75rem auto;
        }
    }
    @media (max-width: 479px) {
        .modal-post-show{
            max-width: 100%;
        }
    }
</style>
