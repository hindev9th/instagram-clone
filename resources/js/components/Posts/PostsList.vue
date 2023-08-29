<template>
    <div class="col-md-8 d-flex flex-column align-items-center posts" id="posts">
        <div class="post-new" v-if="posts">
            <Post :user="getAuth" :post="post" v-for="(post,index) in posts.data" :key="index" ></Post>
            <infinite-loading @infinite="infiniteLoad" v-if="posts.last_page > page"></infinite-loading>
        </div>
        <div class="message-end-post pt-3" v-if="isShowMessageEnd ||( posts && posts.total === 0)">
            <h5 class="font-weight-bold">You're all caught up</h5>
            <span>You've seen all new posts from the past 3 days.</span>
            <router-link class="" :to="{name: 'past'}" >View older posts</router-link>
        </div>
        <div class="remember small col-md-4">
            <div class="title-sug-user d-flex justify-content-between">
                <span class="mt-2">Suggested for you</span>
                <ShowUserButton :action="sug_user" title="Suggested for you" text="See All"></ShowUserButton>
            </div>
            <SuggestedUsers></SuggestedUsers>
        </div>
        <div class="post-suggested border-top w-100" v-if="postsSug">
            <div class="title-sug-post d-flex justify-content-between">
                <h5 class="mt-2 font-weight-bold">Suggested Posts</h5>
            </div>
            <Post :user="getAuth" :post="post" v-for="(post,index) in postsSug.data" :key="index" ></Post>
            <infinite-loading @infinite="infiniteLoadSuggested"></infinite-loading>
        </div>
    </div>
</template>

<script>
import Post from "./Post";
import {mapActions, mapGetters} from 'vuex';
import SuggestedUsers from "../User/SuggestedUsers";
import ShowUserButton from "../User/Buttons/ShowUserButton";
import {USER_SUGGESTED} from "../../api/userApi";
export default {
    components : {Post,SuggestedUsers,ShowUserButton},
    name: "PostsList",
    data() {
        return {
            auth_data : window.Laravel,
            page : 1,
            page_sug: 1,
            isLoading : false,
            isShowMessageEnd : false,
            sug_user: USER_SUGGESTED,
        }
    },
    created() {
        this.fetchPosts(this.page).then(e => {
            if(this.posts.total === 0 ){
              this.fetchPostSug(this.page_sug);
            }
        });
    },
    computed:{
        ...mapGetters('auth',['getAuth']),
        ...mapGetters('post',{
          posts : 'getPosts',
          postsSug : 'getPostsSug',
        }),
    },
    mounted() {
        Bus.$on('new-post', post => {
            this.posts.unshift(post);
        })
        Bus.$on('delete-post', post => {
            this.deletePost(post);
        })

        Bus.$on('update-post',post => {
            this.updatePost(post);
        })
    },
    methods: {
        ...mapActions('post',['fetchPosts','fetchPostSug']),

        updatePost(post){
            for (var index in this.posts){
                if (this.posts[index].id === post.id){
                    this.$set(this.posts,index,post);
                    break;
                }
            }
        },
        deletePost(removePost){
            for (var index in this.posts){
                if (this.posts[index].id === removePost.id){
                    this.$delete(this.posts,index);
                    break;
                }
            }
        },
        infiniteLoad($state){
            setTimeout(()=>{
                this.page++;
                this.fetchPosts(this.page).then(e => {
                    if (this.posts.last_page <= this.page){
                        $state.complete();
                        this.isShowMessageEnd = true;
                        this.fetchPostSug(this.page_sug);
                    }else {
                        $state.loaded();
                    }
                })
            },1000)

        },
        infiniteLoadSuggested($state){
            setTimeout(()=>{
                this.page_sug++;
                this.fetchPostSug(this.page_sug).then(e => {
                    if (this.postsSug.last_page <= this.page_sug){
                        $state.complete();
                    }else {
                        $state.loaded();
                    }
                })
            },1000)
        }
    },
}
</script>

<style scoped>
    #posts::-webkit-scrollbar{
        display: none;
    }
    .message-end-post{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
