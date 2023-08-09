<template>
    <div class="user d-flex mt-2 mb-3 align-items-center justify-content-between">
        <div class="info d-flex">
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
export default {
    components : {FollowButton},
    name: "User",
    props: ['user'],
    data(){
        return{
            auth_data : window.Laravel,
        }
    },
    computed:{
        ...mapGetters('user',{
            auth : 'getAuth',
        })
    },
    methods:{
        getImage,
    }
}
</script>

<style scoped>

</style>
