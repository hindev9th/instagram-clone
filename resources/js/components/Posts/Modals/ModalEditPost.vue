<template>
    <div class="modal fade" id="modal-edit-post" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xxl" role="document">
            <div class="modal-content overflow-hidden border-0">
                <form action="#" @submit="sharePost" method="post" enctype="multipart/form-data">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <span class="close-new-modal-post prevent-select cursor-pointer pl-3 text-danger text-decoration-none"
                              data-dismiss="modal" @click="$emit('close-modal')"><strong>
                            Close</strong></span>
                        <strong>Edit info</strong>
                        <button class="btn text-primary font-weight-bold focus-none" :disabled="isChange || isLoading">
                            <span class="spinner-border mr-1 spinner-border-sm" v-if="isLoading" role="status"
                                  aria-hidden="true"></span>
                            {{ isLoading ? 'Sharing...' : 'Share' }}
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="box-new-post row m-0 w-100 d-flex h-100">
                            <div
                                class="box-image d-flex col-md-8 align-items-center justify-content-center border-right">
                                <label for="image-edit" class="col-form-label custom-file-image-label"
                                       :style="{background : (url === '' ? '' : 'url(' + url + ') no-repeat')}"></label>

                                <input id="image-edit" accept='image/*' @change="onFileChange" :disabled="isLoading"
                                       type="file" class="form-control-file" name="image"
                                       autocomplete="image">
                            </div>
                            <div class="col-md-4 box-content">
                                <div class="box-user pt-2 pb-2">
                                    <img :src="getImage(user.profile.image)" class="avatar rounded-circle"
                                         alt="">
                                    <strong>{{ user.username }}</strong>
                                </div>
                                <textarea id="caption-edit" type="text"
                                          class="form-control p-0 border-0 bg-transparent"
                                          rows="10"
                                          name="caption"
                                          @input="change"
                                          v-model="inputCaption"
                                          :readonly="isLoading"
                                          required
                                          autocomplete="caption"
                                          placeholder="Write a caption..."
                                          autofocus></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage} from "../../../functiton";
import $ from "jquery";
import {mapActions} from "vuex";
export default {
    name: "ModalEditPost",
    props: ['post','user'],
    data() {
        return {
            url: '',
            file: null,
            inputCaption: this.post.caption,
            isLoading: false,
            isChange : true,
            auth_data : window.Laravel,
        }
    },
    computed:{

    },
    mounted() {
        this.url = `${window.Laravel.baseUrl}/storage/${this.post.image}`;
    },
    methods: {
        getImage,
        ...mapActions('post',['updatePost']),
        onFileChange(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);

            this.file = file;
        },
        sharePost(e){
            e.preventDefault();
            this.isLoading = true;

            let formData = new FormData();
            formData.append('_method', 'PATCH');
            formData.append('caption', this.inputCaption);
            if (this.file != null){
                formData.append('image', this.file);
            }


            this.updatePost({id : this.post.id,post : formData}).then(e => {
                this.isLoading = false;
                $('#modal-edit-post').modal('hide');
                this.$emit('close-modal');
                this.url = '';
                this.inputCaption = '';
                this.file = null;
            }).catch(e => {
                this.isLoading = false;
            })

        },
        change(){
            this.isChange = this.inputCaption === this.post.caption;
        }

    },
}
</script>

<style scoped>

</style>
