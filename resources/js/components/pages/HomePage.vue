<template>
    <div class="box-main">
        <div class="post-home container">
            <div class="box-post d-flex justify-content-around w-100">
                <PostsList></PostsList>
                <div class="remember col-md-4">
                    <div class="box-user align-items-center justify-content-between" style="border-radius: 0.7rem;">
                        <div class="box-info d-flex align-items-center" v-if="getAuth && getAuth.profile">
                            <div
                                class="avatar">
                                <router-link
                                    :to="{name:'profile', params : {username : getAuth.username}}">
                                    <img :src="getImage(getAuth.profile.image)" alt="" class=" " style="left: -5px">
                                </router-link>>
                            </div>
                            <div class="box-name d-flex flex-column">
                                <router-link
                                    class="text-dark text-decoration-none username"
                                    :to="{name:'profile', params : {username : getAuth.username}}">
                                    <strong class="username">{{ getAuth.username }}</strong>
                                </router-link>
                                <span class="name">{{ getAuth.name }}</span>
                            </div>
                        </div>
                        <div class="logout pl-2 pr-2 cursor-pointer prevent-select text-primary" @click="logOut()">
                             Logout
                        </div>
                    </div>
                    <div class="title-sug-user d-flex justify-content-between">
                        <span class="mt-2">Suggested for you</span>
                        <ShowUserButton :action="sug_user" title="Suggested for you" text="See All"></ShowUserButton>
                    </div>
                    <SuggestedUsers></SuggestedUsers>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage} from "../../functiton";
import {SUGGESTED_USER} from "../../api/userApi";
import {mapGetters,mapActions} from 'vuex';
import SuggestedUsers from "../User/SuggestedUsers";
import ShowUserButton from "../User/Buttons/ShowUserButton";
import PostsList from "../Posts/PostsList";
export default {
    components : {SuggestedUsers,ShowUserButton,PostsList},
    name: "HomePage",
    data(){
        return{
            Laravel : window.Laravel,
            sug_user : SUGGESTED_USER,
        }
    },
    computed:{
        ...mapGetters('user',['getAuth']),
    },
    methods:{
        ...mapActions('user',['logOut']),
        getImage,

    }
}
</script>

<style scoped>

</style>
