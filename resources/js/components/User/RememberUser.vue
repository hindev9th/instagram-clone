<template>
    <div class="remember col-md-4" v-if="auth && auth.profile">
        <div class="box-user align-items-center justify-content-between" style="border-radius: 0.7rem;">
            <div class="box-info d-flex align-items-center">
                <div
                    class="avatar">
                    <router-link
                        :to="{name:'profile', params : {username : auth.username}}">
                        <img :src="getImage(auth.profile.image)" alt="" class=" " style="left: -5px">
                    </router-link>>
                </div>
                <div class="box-name d-flex flex-column">
                    <router-link
                        class="text-dark text-decoration-none username"
                        :to="{name:'profile', params : {username : auth.username}}">
                        <strong class="username">{{ auth.username }}</strong>
                    </router-link>
                    <span class="name">{{ auth.name }}</span>
                </div>
            </div>
            <div class="logout cursor-pointer prevent-select text-primary" @click="logOutAccount()">
                Logout
            </div>
        </div>
        <div class="title-sug-user d-flex justify-content-between">
            <span class="mt-2">Suggested for you</span>
            <ShowUserButton :action="sug_user" title="Suggested for you" text="See All"></ShowUserButton>
        </div>
        <SuggestedUsers></SuggestedUsers>
    </div>
</template>

<script>
import ShowUserButton from "./Buttons/ShowUserButton";
import SuggestedUsers from "./SuggestedUsers";
import {mapActions, mapGetters} from "vuex";
import {getImage} from "../../functiton";
import {USER_SUGGESTED} from "../../api/userApi";

export default {
    components : {SuggestedUsers,ShowUserButton},
    name: "RememberUser",
    data(){
        return{
            sug_user : USER_SUGGESTED,
        }
    },
    computed:{
        ...mapGetters('user', {
            auth: 'getAuth',
        }),
    },
    methods:{
        ...mapActions('user',['logOut']),
        getImage,
        logOutAccount(){
            this.logOut().then(window.location.reload())
        }

    }
}
</script>

<style scoped>

</style>
