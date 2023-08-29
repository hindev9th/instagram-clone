<template>
    <div class="user d-flex mt-2 mb-3 align-items-center justify-content-between" @mouseover="showInfo">
        <div class="info d-flex" >
            <div class="avatar">
                <router-link :to="{name : 'profile' , params : {username : user.username}}">
                    <img :src="getImage(user.profile.image)" alt="">
                </router-link>
            </div>
            <div class="name d-flex flex-column">
                <router-link class="text-dark text-decoration-none" :to="{name : 'profile' , params : {username : user.username}}">
                    <strong>{{ user.username }}</strong>
                </router-link>
                <span class="text-black-50" style="font-size: 10px">{{ user.name }}</span>
            </div>
            <user-hover :username="user.username" v-if="isShowInfo" ></user-hover>
        </div>
        <follow-button :username="user.username"
                       :follows="user.isFollowed"
                       v-if="user.id !== auth.id"
                       class="text-primary"></follow-button>
    </div>
</template>

<script>
import FollowButton from "../FollowButton";
import {getImage} from "../../functiton";
import {mapGetters} from "vuex";
import UserHover from "./Hover/UserHover";
export default {
    components : {UserHover, FollowButton},
    name: "User",
    props: ['user'],
    data(){
        return{
            isShowInfo : false,
        }
    },
    computed:{
        ...mapGetters('auth',{
            auth : 'getAuth',
        })
    },
    methods:{
        getImage,
        showInfo(){
            setTimeout(()=>{
               this.isShowInfo = true;
            },1000);
        }
    }
}
</script>

<style scoped>

</style>
