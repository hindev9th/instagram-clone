<template>
    <div class="post-show">
        <div class="img-post w-50 d-flex justify-content-center align-items-center">
            <img :src="'/storage/'+postData.image" class="w-100" style="height: fit-content" alt="">
        </div>
        <div class="box-action-post position-relative p-0">
            <div class="d-flex flex-column mw-100">
                <div class="box-user-post border-bottom position-relative">
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
                    <div class="box-post p-2 w-100 bg-white">
                        <div class="icon-button d-flex">
                            <LikeButton :post="postData" :user="auth_user" @add-like="addLike" @minus-like="minusLike"></LikeButton>
                            <a href="#comment"><i class="far fa-comment ml-2"
                                                  style="color: #212529; font-size: 25px"></i></a>
                            <ShareButton :post="postData"></ShareButton>
                        </div>
                        <div class="info-post pt-2 d-flex flex-column">
                            <strong>{{ formatNumber(likes) }} likes</strong>
                            <span>{{formatTime(postData.created_at)}}</span>
                        </div>
                    </div>

                    <div class="border-top pt-3 w-100 bg-white">
                        <CommentForm :user="auth_user" :post="postData" ></CommentForm>
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
import {getImage,formatNumber,formatTime} from "../../functiton";
export default {
    components: {CommentForm,Comments,LikeButton,SettingButton,ShareButton},
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
        fetchComments(){
            axios.get(this.base_url+'/api/comments/'+this.post.id)
            .then(res => {

            })
        },
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
