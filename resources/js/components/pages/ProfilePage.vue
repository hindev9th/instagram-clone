<template>
    <div class="box-main">
        <div class="container">
            <div class="row pb-5 border-bottom" v-if="getProfile.profile">
                <div class="col-sm-3">
                    <img
                        :src="getImage(getProfile.profile.image)"
                        width="200px"
                        height="200px"
                        class="rounded-circle">
                </div>
                <div class="col-sm-9 pt-4">
                    <div class="container">
                        <div class="row ">
                            <div class="d-flex">
                                <h2 class="pr-3" v-text="getProfile.username"></h2>

                                <a href="#"
                                   class="btn btn-primary"
                                   v-if="getProfile.id === getAuth.id"
                                   style="height: fit-content;"
                                   title="Edit profile">Edit profile</a>
                                <div v-else>
                                    <follow-button :user-id="getProfile.id" :follows="getProfile.isFollowed" class="btn btn-primary text-right"></follow-button>
                                    <router-link class="btn btn-primary ml-2" :to="{name : 'chat'}">
                                        Message
                                    </router-link>
                                </div>
                            </div>


                        </div>
                        <div class="row pb-3">
                            <div class="pr-5"><strong>{{ getProfile.posts_count }}</strong> posts</div>
                            <div class="pr-5 d-flex"><strong>{{ getProfile.followers_count }}</strong> &nbsp
                                <show-user-button action="#"
                                                  title="followers"
                                                  text="followers"></show-user-button>
                            </div>
                            <div class="pr-5 d-flex"><strong>{{ getProfile.following_count }}</strong> &nbsp
                                <show-user-button action="#"
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
                            <a href="#">
                                <img :src="`/storage/${post.image}`" class="w-100" alt="">
                            </a>
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

export default {
    name: "ProfilePage",
    data(){
        return{
            page : 1,
        }
    },
    created() {
        this.fetchProfile(this.$route.params.username);
        this.fetchPosts(this.$route.params.username);
    },
    computed:{
        ...mapGetters('profile',['getProfile','getPosts']),
        ...mapGetters('user',['getAuth']),
    },
    methods:{
        getImage,
        ...mapActions('profile',['fetchProfile','fetchPosts',"fetchMorePosts"]),
        infiniteLoad($state){
            setTimeout(() => {
                this.page++;
                this.fetchMorePosts({'username' : this.$route.params.username , 'page' : this.page}).then(e => {
                    if (this.page === this.getPosts.last_page){
                        $state.complete()
                    }else {
                        $state.loaded();
                    }
                });
            },1000)

        }
    }
}
</script>

<style scoped>

</style>
