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
                        <router-link class="text-decoration-none text-dark pr-2" :to="{name : 'profile',params : {username: post.user.username}}">
                            <strong>{{ post.user.username }}</strong>
                        </router-link>
                        <i class="fas fa-circle pr-2" style="font-size: 5px"></i>
                        <div class="font-weight-normal">{{ formatTime(post.created_at) }}</div>
                    </div>

                </div>
            </div>
            <SettingButton :post="post" :user="getAuth"></SettingButton>
        </div>
        <div class="border rounded-lg overflow-hidden d-flex justify-content-center align-items-center">
            <img :src="base_url + '/storage/' + post.image" class="w-100" style="height: fit-content"
                 alt="">
        </div>
        <div class="w-100 p-0 mh-100">
            <div class="mw-100">
                <div class="box-interact w-100 pt-2">
                    <div class="icon-button d-flex">
                        <LikeButton :post="post" @add-like="addLike" @minus-like="minusLike"></LikeButton>
                        <CommentButton :post="post" :user="getAuth" text="" ></CommentButton>
                        <ShareButton :post="post"></ShareButton>
                    </div>
                    <div class="info-post pt-2 d-flex flex-column">
                        <strong class="d-flex">{{ formatNumber(likesCount) }} &nbsp
                            <ShowUserButton :action="`${base_url}/api/p/${post.id}/likes`" title="Likes" text="Likes"></ShowUserButton>
                        </strong>
                    </div>
                    <div class="row m-0 pt-2 pb-2">
                        <div class="w-100">
                            <a :href="base_url + '/profile/' + post.user.username"
                               class="text-decoration-none text-dark"><strong>{{ post.user.username }}</strong></a>
                            <span v-html="extractTagsFromString(post.caption)"></span>
                        </div>
                    </div>
                    <CommentButton :post="post" :user="getAuth" :text="`View all ${formatNumber(commentsCount)} comments`" ></CommentButton>
                    <Comment :comment="comment" :key="index" v-for="(comment,index) in newComments"></Comment>
                    <CommentForm :post="post"  class="border-bottom pb-3"></CommentForm>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage, formatTime, formatNumber, extractTagsFromString} from "../../functiton";
import LikeButton from "./Buttons/LikeButton";
import CommentButton from "./Buttons/CommentButton";
import SettingButton from "./Buttons/SettingButton";
import CommentForm from "./Comments/CommentForm";
import ShareButton from "./Buttons/ShareButton";
import ShowUserButton from "../User/Buttons/ShowUserButton";
import Comment from "./Comments/Comment";
import {mapGetters} from "vuex";
export default {
    components: {LikeButton,CommentButton,SettingButton,CommentForm,ShareButton,ShowUserButton,Comment},
    name: "Post",
    props: ['post','user'],
    data() {
        return {
            posts : [],
            base_url : window.Laravel.baseUrl,
            likesCount : this.post.likes_count,
            commentsCount : this.post.comments_count,
            newComments : [],
        }
    },
    computed:{
        ...mapGetters('user',['getAuth']),
    },
    mounted() {
        Bus.$on(`new-comment-${this.post.id}`, comment =>{
            this.newComments.push(comment);
            this.comments++;
        })
    },
    methods:{
        getImage,formatNumber,formatTime,extractTagsFromString,
        addLike(){
            this.likesCount++;
        },
        minusLike(){
            this.likesCount--;
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
