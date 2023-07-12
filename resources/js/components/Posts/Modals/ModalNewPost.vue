<template>
    <div class="modal fade" id="modal-new-post" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content overflow-hidden border-0">
                <div class="modal-body p-0">
                    <div
                        class="title d-flex justify-content-between align-items-center pt-1 pb-1 border-bottom">
                        <span class="close-new-modal-post pl-3 text-danger text-decoration-none" data-dismiss="modal"><strong>
                            Close</strong></span>
                        <strong>Add new post</strong>
                        <button class="btn text-primary font-weight-bold">Share</button>
                    </div>
                    <div class="box-new-post row m-0 w-100 d-flex h-100">
                        <div class="box-image d-flex col-md-8 align-items-center justify-content-center border-right">
                            <label for="image" class="col-form-label custom-file-image-label" :style="{background : 'url(' + url + ') no-repeat'}"></label>

                            <input id="image" @change="onFileChange" type="file" class="form-control-file" name="image"
                                   value=""
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
                                      required
                                      autocomplete="caption"
                                      placeholder="Write a caption..."

                                      autofocus></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage} from "../../../functiton";

export default {
    name: "ModalNewPost",
    props: ['user'],
    data() {
        return {
            auth_user: JSON.parse(this.user),
            url: '',
        }
    },
    methods: {
        getImage,
        onFileChange(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },

    }
}
</script>

<style scoped>
.box-image {
    width: 100vh;
    height: 60vh;
}
.close-new-modal-post{
    cursor: pointer;
}
</style>
