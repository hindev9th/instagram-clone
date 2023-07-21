<template>
    <div class="post-show position-relative">
        <div v-if="!isLoading">
            <div class="box-user-post top position-relative pt-2 pb-2 pr-2 pl-0">
                <div class="box-user p-0 d-flex">
                    <div class="pr-1 pl-2">
                        <img :src="getImage(post.user.profile.image)" class="avatar rounded-circle"
                             alt="">
                    </div>
                    <div class="col-11 pl-2 d-flex align-items-center font-weight-bold">
                        <a :href="`${auth_data.baseUrl}/profile/${post.user.username}`"
                           class="text-decoration-none text-dark pr-2"><strong>{{post.user.username}}</strong></a>
                        <i class="fas fa-circle pr-2" style="font-size: 5px"></i>
                        <div class="font-weight-normal">{{ formatTime(post.created_at) }}</div>
                    </div>
                </div>
                <SettingButton :post="post" :user="auth_user"></SettingButton>
            </div>
            <div class="box-post w-100">
                <div class="img-post d-flex justify-content-center align-items-center">
                    <img :src="`${auth_data.baseUrl}/storage/${post.image}`" class="w-100" style="height: fit-content" alt="">
                </div>
                <div class="box-action-post position-relative p-0">
                    <div class="d-flex flex-column mw-100">
                        <div class="box-user-post border-bottom position-relative pt-2 pb-2 pr-2 pl-0">
                            <div class="box-user p-0 d-flex">
                                <div class="pr-1 pl-2">
                                    <img :src="getImage(post.user.profile.image)" class="avatar rounded-circle"
                                         alt="">
                                </div>
                                <div class="col-11 pl-2 d-flex align-items-center font-weight-bold">
                                    <a :href="auth_data.baseUrl + '/profile/' + post.user.username"
                                       class="text-decoration-none text-dark pr-2"><strong>{{post.user.username}}</strong></a>
                                </div>
                            </div>
                            <SettingButton :post="post" :user="auth_user"></SettingButton>
                        </div>
                        <Comments :post="post" :user="auth_user"></Comments>
                        <div class="d-flex flex-column w-100 m-0 border-top position-absolute" style="bottom: 0;left: 0;">
                            <div class="box-post-action p-2 w-100 bg-white">
                                <div class="icon-button d-flex">
                                    <LikeButton :post="post" :user="auth_user" @add-like="addLike"
                                                @minus-like="minusLike"></LikeButton>
                                    <a href="#comment"><i class="far fa-comment ml-2"
                                                          style="color: #212529; font-size: 25px"></i></a>
                                    <ShareButton :post="post"></ShareButton>
                                </div>
                                <div class="info-post pt-2 d-flex flex-column">
                                    <strong class="d-flex">{{ formatNumber(likes) }} &nbsp
                                        <ShowUserButton :action="`${auth_data.baseUrl}/api/p/${post.id}/likes`" title="Likes" text="Likes"></ShowUserButton>
                                    </strong>
                                    <span>{{ formatTime(post.created_at) }}</span>
                                </div>
                            </div>

                            <CommentForm :user="auth_user" :post="post" class="border-top p-2 w-100 bg-white"></CommentForm>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isLoading" :class="{loading: true, show: isLoading}">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';
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
    props:['user','postId'],
    data(){
        return{
            post : null,
            auth_user : null,
            auth_data : window.Laravel,
            likes : 0,
            isLoading : false,
        }
    },
    created() {
        this.checkJsonUser();
        this.fetchPost();
    },
    mounted() {
        Bus.$on('update-post',post => {
            this.post = post;
        })
    },
    methods:{
        getImage,formatNumber,formatTime,
        addLike(){
            this.likes++;
        },
        minusLike(){
            this.likes--;
        },
        checkJsonUser(){
            try {
                this.auth_user = JSON.parse(this.user)
            }catch (e){
                this.auth_user = this.user;
            }
        },
        fetchPost(){
            this.isLoading = true;
            axios.get(`${this.auth_data.baseUrl}/api/p/${this.postId}?api_token=${this.auth_data.api_token}`)
                .then(res => {
                    this.post = res.data;
                    this.likes = res.data.likes.length;
                    this.isLoading = false;
                })
                .catch(e => {
                });
        }
    }
}
</script>

<style scoped>
    .box-user-post{
        justify-content: space-between;
    }
    .post-show{
        .loading{
            position: absolute;
            top: 0;
            left: 0;
            height: 90vh;
            width: 100%;
            background: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: .3s;
            z-index: 1001;
        }
        .loading.show{
            opacity: 1;
            transition: .3s;
        }
    }
</style>
