<template>
    <div class="post-show position-relative">
        <div class="box-data" v-if="getPost && getPost.user">
            <div class="box-user-post top position-relative pt-2 pb-2 pr-2 pl-0">
                <div class="box-user p-0 d-flex">
                    <div class="pr-1 pl-2" >
                        <img :src="getImage(getPost.user.profile.image)" class="avatar rounded-circle"
                             alt="">
                    </div>
                    <div class="col-11 pl-2 d-flex align-items-center font-weight-bold" >
                        <router-link class="text-decoration-none text-dark pr-2"  :to="{name : 'profile',params : {username :getPost.user.username }}">
                            <strong>{{getPost.user.username}}</strong>
                        </router-link>
                        <i class="fas fa-circle pr-2" style="font-size: 5px"></i>
                        <div class="font-weight-normal">{{ formatTime(getPost.created_at) }}</div>
                    </div>
                </div>
                <SettingButton :post="getPost"  ></SettingButton>
            </div>
            <div class="box-post w-100">
                <div class="img-post d-flex justify-content-center align-items-center">
                    <img :src="`${auth_data.baseUrl}/storage/${getPost.image}`" class="w-100" style="height: fit-content" alt="">
                </div>
                <div class="box-action-post position-relative p-0">
                    <div class="d-flex flex-column mw-100">
                        <div class="box-user-post border-bottom position-relative pt-2 pb-2 pr-2 pl-0">
                            <div class="box-user p-0 d-flex">
                                <div class="pr-1 pl-2"  >
                                    <img :src="getImage(getPost.user.profile.image)" class="avatar rounded-circle"
                                         alt="">
                                </div>
                                <div class="col-11 pl-0 d-flex align-items-center font-weight-bold" >
                                    <router-link class="text-decoration-none text-dark pr-2" :to="{name : 'profile',params : {username :getPost.user.username }}">
                                        <strong v-text="getPost.user.username"></strong>
                                    </router-link>
                                </div>
                            </div>
                            <SettingButton :post="getPost" ></SettingButton>
                        </div>
                        <Comments :post="getPost" ></Comments>
                        <div class="d-flex flex-column w-100 m-0 border-top position-absolute" style="bottom: 0;left: 0;">
                            <div class="box-post-action p-2 w-100 bg-white">
                                <div class="icon-button d-flex">
                                    <LikeButton :post="getPost" @add-like="addLike"
                                                @minus-like="minusLike"></LikeButton>
                                    <a href="#comment"><i class="far fa-comment ml-2"
                                                          style="color: #212529; font-size: 25px"></i></a>
                                    <ShareButton :post="getPost"></ShareButton>
                                </div>
                                <div class="info-post pt-2 d-flex flex-column">
                                    <strong class="d-flex">{{ formatNumber(likesCount) }} &nbsp
                                        <ShowUserButton :action="`${auth_data.baseUrl}/api/p/${getPost.id}/likes`" title="Likes" text="Likes"></ShowUserButton>
                                    </strong>
                                    <span>{{ formatTime(getPost.created_at) }}</span>
                                </div>
                            </div>

                            <CommentForm :post="getPost" class="border-top p-2 w-100 bg-white"></CommentForm>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!getPost" :class="{loading: true, show: isLoading}">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
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
import {mapActions, mapGetters} from "vuex";
export default {
    components: {CommentForm,Comments,LikeButton,SettingButton,ShareButton,ShowUserButton},
    name: "PostShow",
    props : ['post'],
    data(){
        return{
            auth_data : window.Laravel,
            likesCount : 0,
            isLoading : true,
        }
    },
    created() {
        let postId = this.$route.params.id ? this.$route.params.id : this.post.id
        this.fetchPost(postId).then(e => {
            this.likesCount = this.getPost.likes_count;
        });
    },
    mounted() {
        Bus.$on('update-post',post => {

        })
    },
    computed:{
      ...mapGetters('auth',['getAuth']),
      ...mapGetters('post',['getPost']),
    },
    methods:{
        ...mapActions('post',['fetchPost']),
        getImage,formatNumber,formatTime,
        addLike(){
            this.likesCount++;
        },
        minusLike(){
            this.likesCount--;
        },
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
    @media (max-width: 479px){
        .post-show .box-data{
            width: 100%;
        }
    }
</style>
