<template>
    <div class="modal fade" id="modal-new-post" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xxl" role="document">
            <div class="modal-content overflow-hidden border-0">
                <form action="#" @submit="sharePost" method="post" enctype="multipart/form-data">
                <div class="modal-header d-flex justify-content-between align-items-center">
                        <span class="close-new-modal-post prevent-select pl-3 text-danger text-decoration-none"
                              data-dismiss="modal"><strong>
                            Close</strong></span>
                    <strong>Add new post</strong>
                    <button class="btn text-primary font-weight-bold focus-none" :disabled="isLoading">
                        <span class="spinner-border mr-1 spinner-border-sm" v-if="isLoading" role="status" aria-hidden="true"></span>
                        {{ isLoading ?'Sharing...' : 'Share'}}
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="box-new-post row m-0 w-100 d-flex h-100">
                        <div class="box-image d-flex col-md-8 align-items-center justify-content-center border-right">
                            <label for="image" class="col-form-label custom-file-image-label"
                                   :style="{background : (url === '' ? '' : 'url(' + url + ') no-repeat')}"></label>

                            <input id="image" accept='image/*' @change="onFileChange" :disabled="isLoading" type="file" class="form-control-file" name="image"
                                   required autocomplete="image">
                        </div>
                        <div class="col-md-4 box-content">
                            <div class="box-user pt-2 pb-2">
                                <img :src="getImage(auth_user.profile.image)" class="avatar rounded-circle"
                                     alt="">
                                <strong>{{ auth_user.username }}</strong>
                            </div>
                            <textarea id="caption" type="text"
                                      class="form-control p-0 border-0 bg-transparent"
                                      rows="10"
                                      name="caption"
                                      v-model="inputCaption"
                                      :readonly="isLoading"
                                      required
                                      autocomplete="caption"
                                      placeholder="Write a caption..."
                                      autofocus></textarea>
                        </div>
                    </div>
                </div>
                    {{ url }}
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage} from "../../../functiton";
import $ from 'jquery';
export default {
    name: "ModalNewPost",
    props: ['user'],
    data() {
        return {
            auth_user: JSON.parse(this.user),
            url: '',
            file: null,
            inputCaption: '',
            isLoading: false,
            baseUrl: window.Laravel.baseUrl,
        }
    },
    methods: {
        getImage,
        onFileChange(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);

            this.file = file;

        },
        sharePost(e){
            e.preventDefault();
            this.isLoading = true;

            let formData = new FormData();
            formData.append('image', this.file);
            formData.append('caption', this.inputCaption);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }

            axios.post(this.baseUrl + '/p',formData,config)
            .then(res => {
                this.isLoading = false;
                $('#modal-new-post').modal('hide');
            })
            .catch(e =>{
                this.isLoading = false;
            })
        }

    }
}
</script>

<style scoped>
.box-image {
    width: 100vh;
    height: 60vh;
}

.close-new-modal-post {
    cursor: pointer;
}
@media (max-width: 767px) {
    .box-image {
        height: 45vh;
    }

}
</style>
