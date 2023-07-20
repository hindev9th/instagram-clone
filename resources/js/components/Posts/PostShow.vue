<template>

    <div class="post-show">
        <div class="box-user-post top position-relative pt-2 pb-2 pr-2 pl-0">
            <div class="box-user d-flex">
                <div class="pr-1 pl-2">
                    <img :src="getImage(postData.user.profile.image)" class="avatar rounded-circle"
                         alt="">
                </div>
                <div class="col-11 pl-2 d-flex align-items-center font-weight-bold">
                    <a :href="base_url + '/profile/' + postData.user.username"
                       class="text-decoration-none text-dark pr-2"><strong>{{postData.user.username}}</strong></a>
                    <i class="fas fa-circle pr-2" style="font-size: 5px"></i>
                    <div class="font-weight-normal">{{ formatTime(postData.created_at) }}</div>
                </div>
            </div>
            <SettingButton :post="postData" :user="auth_user"></SettingButton>
        </div>
        <div class="box-post w-100">
            <div class="img-post d-flex justify-content-center align-items-center">
                <img :src="'/storage/'+postData.image" class="w-100" style="height: fit-content" alt="">
            </div>
            <div class="box-action-post position-relative p-0">
                <div class="d-flex flex-column mw-100">
                    <div class="box-user-post border-bottom position-relative pt-2 pb-2 pr-2 pl-0">
                        <div class="box-user d-flex">
                            <div class="pr-1 pl-2">
                                <img :src="getImage(postData.user.profile.image)" class="avatar rounded-circle"
                                     alt="">
                            </div>
                            <div class="col-11 pl-2 d-flex align-items-center font-weight-bold">
                                <a :href="base_url + '/profile/' + postData.user.username"
                                   class="text-decoration-none text-dark pr-2"><strong>{{postData.user.username}}</strong></a>
                            </div>
                        </div>
                        <SettingButton :post="postData" :user="auth_user"></SettingButton>
                    </div>
                    <Comments :post="postData" :user="auth_user"></Comments>
                    <div class="d-flex flex-column w-100 m-0 border-top position-absolute" style="bottom: 0;left: 0;">
                        <div class="box-post-action p-2 w-100 bg-white">
                            <div class="icon-button d-flex">
                                <LikeButton :post="postData" :user="auth_user" @add-like="addLike"
                                            @minus-like="minusLike"></LikeButton>
                                <a href="#comment"><i class="far fa-comment ml-2"
                                                      style="color: #212529; font-size: 25px"></i></a>
                                <ShareButton :post="postData"></ShareButton>
                            </div>
                            <div class="info-post pt-2 d-flex flex-column">
                                <strong class="d-flex">{{ formatNumber(likes) }} &nbsp
                                    <ShowUserButton :action="`${base_url}/api/p/${postData.id}/likes`" title="Likes" text="Likes"></ShowUserButton>
                                </strong>
                                <span>{{ formatTime(postData.created_at) }}</span>
                            </div>
                        </div>

                        <CommentForm :user="auth_user" :post="postData" class="border-top p-2 w-100 bg-white"></CommentForm>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import CommentForm from "./Comments/CommentForm";
import Comments from "./Comments/Comments";
import LikeButton from "./Buttons/LikeButton";
import SettingButton from "./Buttons/SettingButton";
import ShareButton from "./Buttons/ShareButton";
import ShowUserButton from "../User/Buttons/ShowUserButton";
import {getImage,formatNumber,formatTime} from "../../functiton";
export default {
    components: {CommentForm,Comments,LikeButton,SettingButton,ShareButton,ShowUserButton},
    name: "PostShow",
    props:['user','post'],
    data(){
        return{
            postData : JSON.parse(this.post),
            auth_user : JSON.parse(this.user),
            base_url : window.Laravel.baseUrl,

            likes : 0,
        }
    },
    mounted() {
        this.likes = this.postData.likes.length;
    },
    methods:{
        getImage,formatNumber,formatTime,
        addLike(){
            this.likes++;
        },
        minusLike(){
            this.likes--;
        }
    }
}
</script>

<style scoped>
    .box-user-post{
        justify-content: space-between;
    }
</style>
