<template>
    <div class="col-md-8 d-flex flex-column align-items-center posts" id="posts">
        <Post :user="auth_user" :post="post" v-for="(post,index) in posts" :key="index" ></Post>
        <span class="text-primary prevent-select cursor-pointer m-3" v-if="isShowLoadMore && !isLoading" @click="fetchPosts">Load more</span>
    </div>
</template>

<script>
import Post from "./Post";
export default {
    components : {Post},
    name: "PostsList",
    props: ['user'],
    data() {
        return {
            posts : null,
            auth_user : JSON.parse(this.user),
            auth_data : window.Laravel,
            page : 0,
            isLoading : false,
            isShowLoadMore : true,
        }
    },
    created() {
        this.fetchPosts();
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
        fetchPosts() {
            this.isLoading = true;
            this.page++;
            axios.get(`${this.auth_data.baseUrl}/api/p?api_token=${this.auth_data.api_token}&page=${this.page}`)
                .then(res => {
                    this.isLoading = false;
                    if (this.posts == null){
                        this.posts = res.data.data;
                    }else {
                        res.data.data.forEach(e => this.posts.push(e));
                    }
                    this.isShowLoadMore = this.posts.length < res.data.total;
                })
                .catch(e => {
                    this.isLoading = false;
                })
        },
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
        }
    },
}
</script>

<style scoped>
    #posts::-webkit-scrollbar{
        display: none;
    }
</style>
