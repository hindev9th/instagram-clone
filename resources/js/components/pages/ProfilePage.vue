<template>
    <div class="box-main">
        <div class="container profile" v-if="isLoading">
            <div class="box-info-user d-flex pb-5 border-bottom" v-if="getProfile.profile">
                <div class="pr-4">
                    <img
                        :src="getImage(getProfile.profile.image)"
                        width="200px"
                        height="200px"
                        class="rounded-circle">
                </div>
                <div class="pt-4 info">
                    <div class="container">
                        <div class="row ">
                            <div class="d-flex">
                                <h2 class="pr-3" v-text="getProfile.username"></h2>

                                <router-link
                                   class="btn btn-primary"
                                   v-if="getProfile.id === getAuth.id"
                                   :to="{name : 'account'}"
                                   style="height: fit-content;"
                                   title="Edit profile">Edit profile</router-link>
                                <div v-else>
                                    <follow-button :username="getProfile.username" :follows="getProfile.isFollowed" class="btn btn-primary text-right"></follow-button>
                                    <router-link class="btn btn-primary ml-2" :to="{name : 'chat'}">
                                        Message
                                    </router-link>
                                </div>
                            </div>


                        </div>
                        <div class="row pb-3">
                            <div class="pr-5"><strong>{{ getProfile.posts_count }}</strong> posts</div>
                            <div class="pr-5 d-flex"><strong>{{ getProfile.followers_count }}</strong> &nbsp
                                <show-user-button :action="`${resource_follows}/${getProfile.username}/followers`"
                                                  title="followers"
                                                  text="followers"></show-user-button>
                            </div>
                            <div class="pr-5 d-flex"><strong>{{ getProfile.following_count }}</strong> &nbsp
                                <show-user-button :action="`${resource_follows}/${getProfile.username}/following`"
                                                  title="following"
                                                  text="following"></show-user-button>
                            </div>
                        </div>
                        <div class="row"><strong>{{ getProfile.profile.title }}</strong></div>
                        <div class="row">{{ getProfile.profile.description }}</div>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active " id="POSTS" v-if="getPosts">
                    <div class="row" >
                        <div class="col-4 p-1" v-for="post in getPosts.data" >
                            <span @click="showPost(post.id)"
                                  data-toggle="modal"
                                  data-backdrop="static"
                                  data-keyboard="false"
                                  data-target="#modal-post-show"
                                  class="cursor-pointer">
                                <img :src="`${baseUrl}/storage/${post.image}`" class="w-100" alt="">
                            </span>
                            <modal-post-show :post="post" v-if="post.id === indexShowPost" @close-modal="hidePost"></modal-post-show>

                        </div>
                    </div>
                    <infinite-loading @infinite="infiniteLoad"></infinite-loading>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {getImage} from "../../functiton";
import ModalPostShow from "../Posts/Modals/ModalPostShow";
import FollowButton from "../FollowButton";
import ShowUserButton from "../User/Buttons/ShowUserButton";
import {RESOURCE_FOLLOWS} from "../../api/followApi";

export default {
    components : {ModalPostShow,FollowButton,ShowUserButton},
    name: "ProfilePage",
    data(){
        return{
            isLoading : false,
            page : 1,
            indexShowPost : null,
            baseUrl : Laravel.baseUrl,
            resource_follows : RESOURCE_FOLLOWS,
        }
    },
    created() {
        this.fetchProfileAndPosts(this.$route.params.username).then(()=>{
            this.isLoading = true;
        }).catch(()=>{});
    },
    computed:{
        ...mapGetters('profile',['getProfile','getPosts']),
        ...mapGetters('user',['getAuth']),
    },
    methods:{
        getImage,
        ...mapActions('profile',['fetchProfileAndPosts',"fetchMorePosts"]),
        infiniteLoad($state){
            setTimeout(() => {
                this.page++;
                this.fetchMorePosts({'username' : this.$route.params.username , 'page' : this.page}).then(() => {
                    if (this.page >= this.getPosts.last_page ){
                        $state.complete()
                    }else {
                        $state.loaded();
                    }
                });
            },1000)

        },
        showPost(index){
            this.indexShowPost = index;
        },
        hidePost(){
            this.indexShowPost = null;
        }
    }
}
</script>

<style scoped>
.profile .box-info-user{
    display: flex;
}
@media (max-width: 478px) {
    .profile .box-info-user{
        flex-direction: column;
        align-items: center;
    }
    .profile .box-info-user .info{
        width: 100%;
    }
}
</style>
