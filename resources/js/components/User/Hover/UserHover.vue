<template>
    <div class="info-user shadow-lg">
        <div class="box-info" v-if="user">
            <div class="header">
                <img :src="getImage(user.profile.image)" alt="" class="avatar">
                <div class="name">
                    <router-link class="text-dark text-decoration-none" :to="{name : 'profile' , params : {username : user.username}}">
                        <strong>{{ user.username }}</strong>
                    </router-link>
                    <span class="text-black-50" style="font-size: 10px">{{ user.name }}</span>
                </div>
            </div>
            <div class="d-flex justify-content-around">
                <div class="d-flex justify-content-center align-items-center flex-column p-2">
                    <strong>{{ user.posts_count }}</strong>
                    <span>Posts</span>
                </div>
                <div class="d-flex justify-content-center align-items-center flex-column p-2">
                    <strong>{{ user.followers_count }}</strong>
                    <span>Followers</span>
                </div>
                <div class="d-flex justify-content-center align-items-center flex-column p-2">
                    <strong>{{ user.following_count }}</strong>
                    <span>Following</span>
                </div>
            </div>
            <div class="posts">
                <div class="col-4" v-for="post in user.posts">
                    <router-link :to="{name : 'post' , params: {id : post.id}}">
                        <img :src="`${baseUrl}/storage/${post.image}`" class="w-100" alt="">
                    </router-link>
                </div>
            </div>
            <div class="footer d-flex">
                <div class="cursor-pointer bg-primary w-100 text-center p-2 m-2 rounded-lg text-white font-weight-bold" v-if="user.isFollowed" @click="handleRedirectChat">Message</div>
                <follow-button :username="user.username"
                               :follows="user.isFollowed"
                               v-if="user.id !== auth.id"
                               class="bg-primary w-100 text-center p-2 m-2 rounded-lg text-white font-weight-bold"></follow-button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import FollowButton from "../../FollowButton";
import {getImage} from "../../../functiton";
export default {
    name: "UserHover",
    components : {FollowButton},
    props : ['username'],
    data(){
        return{
            baseUrl : window.Laravel.baseUrl,
            user : null
        }
    },
    created() {
        this.showUser(this.username).then(res => {
            if (!this.user) this.user = res.data;
        })
    },
    computed: {
        ...mapGetters('auth',{
            auth : 'getAuth',
        })
    },
    methods:{
        getImage,
        ...mapActions('user',['showUser']),
        ...mapActions('chat',['getChatId']),
        handleRedirectChat(){
            this.getChatId([this.user.id]).then(id => {
                if(id){
                    this.$router.push({name : 'message',params : {id : id}}).catch(()=>{});
                }else {
                    this.$router.push({name : 'chat'}).catch(()=>{});
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
