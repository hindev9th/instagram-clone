<template>
    <div class="w-100 post">
        <div class="header-post w-100 m-0 pb-2">
            <div class="header-user d-flex">
                <div class="avatar">
                    <img :src="getImage(post.user.profile.image)"
                         class="" alt="">
                </div>
                <div class="pl-2 d-flex align-items-center justify-content-between font-weight-bold">
                    <div class="d-flex align-items-center">
                        <a :href="base_url + '/profile/' + post.user.username"
                           class="text-decoration-none text-dark pr-2"><strong>{{ post.user.username }}</strong></a>
                        <i class="fas fa-circle pr-2" style="font-size: 5px"></i>
                        <div class="font-weight-normal">{{ formatTime(post.created_at) }}</div>
                    </div>

                </div>
            </div>
            <SettingButton :post="post" :user="user"></SettingButton>
        </div>
        <div class="border rounded-lg overflow-hidden d-flex justify-content-center align-items-center">
            <img :src="base_url + '/storage/' + post.image" class="w-100" style="height: fit-content"
                 alt="">
        </div>
        <div class="w-100 p-0 mh-100">
            <div class="mw-100">
                <div class="box-interact w-100 pt-2">
                    <div class="icon-button d-flex">
                        <LikeButton :post="post" :user="user" @add-like="addLike" @minus-like="minusLike"></LikeButton>
                        <a :href="base_url + '/p/' + post.id"><i
                            class="far fa-comment ml-2" style="color: #212529; font-size: 25px"></i></a>
                        <ShareButton :post="post"></ShareButton>
                    </div>
                    <div class="info-post pt-2 d-flex flex-column">
                        <strong class="d-flex">{{ formatNumber(likes) }} &nbsp
                            <ShowUserButton :action="`${base_url}/api/p/${post.id}/likes`" title="Likes" text="Likes"></ShowUserButton>
                        </strong>
                    </div>
                    <div class="row m-0 pt-2 pb-2">
                        <div class="w-100">
                            <a :href="base_url + '/profile/' + post.user.username"
                               class="text-decoration-none text-dark"><strong>{{ post.user.username }}</strong></a>
                            {{ post.caption }}
                        </div>
                    </div>
                    <a :href="base_url + '/p/' + post.id"
                       class="text-black-50 text-decoration-none">
                        View all {{ formatNumber(comments) }} comments
                    </a>
                    <CommentForm :post="post" :user="user" class="border-bottom pb-3"></CommentForm>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage, formatTime, formatNumber} from "../../functiton";
import LikeButton from "./Buttons/LikeButton";
import SettingButton from "./Buttons/SettingButton";
import CommentForm from "./Comments/CommentForm";
import ShareButton from "./Buttons/ShareButton";
import ShowUserButton from "../User/Buttons/ShowUserButton";
export default {
    components: {LikeButton,SettingButton,CommentForm,ShareButton,ShowUserButton},
    name: "Post",
    props: ['post','user'],
    data() {
        return {
            posts : [],
            base_url : window.Laravel.baseUrl,
            likes : this.post.likes.length,
            comments : this.post.comments.length,
        }
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
.header-post{
    justify-content: space-between;
    align-items: center;
}
</style>
