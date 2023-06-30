<template>
    <div class="modal-overlay">
        <div class="modal-custom">
            <span class="close-button" @click="$emit('close-modal')"><i class="fa fa-times"></i></span>
            <div class="modal-custom-header d-flex flex-column border-bottom pt-3 pb-3">
                <strong>Delete post?</strong>
                <span class="font-weight-normal" >Are you sure you want to delete this post?</span>
            </div>
            <div class="list-items center-modal-list d-flex font-weight-normal flex-column align-items-start">
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="deletePost">
                    <span class="text-danger">Yes</span>
                </div>
                <div class="item pl-4 pt-2 pb-2 pr-4" @click="$emit('close-modal')">
                    <span >Cancel</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalDelete",
    props: ['post_id'],
    methods: {
        deletePost(){

        }
    }
}
</script>

<style scoped>
    .modal-overlay{
        background: transparent;
    }
    .modal-custom .modal-custom-header strong{
        font-size: 20px;
    }
</style>
