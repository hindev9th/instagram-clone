<template>
    <div class="box-main">
        <div class="post-home container">
            <div class="box-post d-flex justify-content-around w-100">
                <div class="col-md-8 d-flex flex-column align-items-center posts" id="posts">
                    <div class="post-old" v-if="getPostsOld">
                        <Post :user="getAuth" :post="post" v-for="(post,index) in getPostsOld.data" :key="index" ></Post>
                        <infinite-loading @infinite="infiniteLoad"></infinite-loading>
                    </div>
                    <div class="remember small col-md-4">
                        <div class="title-sug-user d-flex justify-content-between">
                            <span class="mt-2">Suggested for you</span>
                            <ShowUserButton :action="sug_user" title="Suggested for you" text="See All"></ShowUserButton>
                        </div>
                        <SuggestedUsers></SuggestedUsers>
                    </div>
                </div>
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
import SuggestedUsers from "../../User/SuggestedUsers";
import Post from "../../Posts/Post";
import ShowUserButton from "../../User/Buttons/ShowUserButton";
import {mapGetters,mapActions} from 'vuex';
import {SUGGESTED_USER} from "../../../api/userApi";
import {getImage} from "../../../functiton";
export default {
    components : {SuggestedUsers,Post,ShowUserButton},
    name: "PastPage",
    data(){
        return{
            page: 1,
            sug_user: SUGGESTED_USER,
        }
    },
    created() {
      this.fetchPostOld(this.page);
    },
    computed:{
        ...mapGetters('post',['getPostsOld']),
        ...mapGetters('user',['getAuth']),
    },
    methods:{
        ...mapActions('post',['fetchPostOld']),
        getImage,
        infiniteLoad($state){
            setTimeout(()=>{
                this.page++;
                this.fetchPostOld(this.page).then(e => {
                    if (this.getPostsOld.last_page <= this.page){
                        $state.complete();
                    }else {
                        $state.loaded();
                    }
                })
            },1000)

        },
    }
}
</script>

<style scoped>

</style>
