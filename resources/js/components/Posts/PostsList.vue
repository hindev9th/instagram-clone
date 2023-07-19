<template>
    <div class="col-md-8 d-flex flex-column align-items-center posts" id="posts">
        <Post :user="auth_user" :post="post" v-for="post in posts" :key="post.id" ></Post>
        <button class="btn btn-primary m-5" v-if="isShowLoadMore && !isLoading" @click="loadMorePost">Load more</button>
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
            posts : [],
            base_url : window.Laravel.baseUrl,
            auth_user : JSON.parse(this.user),
            page : 1,
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
    },
    methods: {
        fetchPosts() {
            this.isLoading = true;
            axios.get(this.base_url + '/p')
                .then(res => {
                    this.isLoading = false;
                    this.posts = res.data.data;
                    this.isShowLoadMore = res.data.data.length < res.data.total;
                })
                .catch(e => {
                    this.isLoading = false;
                })
        },
        loadMorePost() {
            this.page++;
            axios.get(this.base_url + '/p?page=' + this.page)
                .then(res => {
                    res.data.data.forEach(e => this.posts.push(e));
                    this.isShowLoadMore = this.posts.length < res.data.total;
                })
                .catch(e =>{
            })

        },
        deletePost(removePost){

            for (var index in this.posts){
                if (this.posts[index].id === removePost.id){
                    console.log(removePost);
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
