<template>
    <div class="box-comments d-flex w-100 mt-2 pl-2 pr-2 overflow-auto mh-100 position-absolute flex-column flex-nowrap" v-if="post.user">
        <div class="d-flex mb-2">
            <div class="pr-1" >
                    <router-link :to="{name : 'profile',params : {username :post.user.username }}">
                    <img :src="getImage(post.user.profile.image)"
                         class="avatar rounded-circle" alt="">
                    </router-link>
            </div>
            <div class="" >
                <router-link class="text-decoration-none text-dark" :to="{name : 'profile',params : {username :post.user.username }}">
                    <strong>{{post.user.username}}</strong>
                </router-link>
                {{ post.caption }}
                <div class="time">
                    {{ formatTime(post.created_at) }}
                </div>
            </div>
        </div>
        <Comment :comment="comment" v-for="comment in comments" :key="comment.id"></Comment>
        <span class="text-primary prevent-select cursor-pointer text-center m-3" @click="showMore" v-if="isShowMore">Show more</span>
    </div>
</template>

<script>
import {getImage,formatTime} from "../../../functiton";
import Comment from './Comment.vue';
export default {
    components: {Comment},
    name: "Comments",
    props: ['post'],
    data(){
        return{
            comments : [],
            isLoading : false,
            auth_data : window.Laravel,
            page : 1,
            isShowMore: false,
        }
    },
    created() {
        this.fetchComments();
    },
    mounted() {
        Bus.$on(`new-comment-${this.post.id}`, comment =>{
            this.comments.push(comment);
        });

        Bus.$on('delete-comment', comment => {
            this.deleteComment(comment);
        })
    },
    methods:{
        getImage,formatTime,
        fetchComments(){
            this.isLoading = true;
            axios.get(`${this.auth_data.baseUrl}/api/p/${this.post.id}/comments?api_token=${this.auth_data.api_token}`)
            .then(res =>{
                this.comments = res.data.data;
                this.isShowMore = res.data.data.length < res.data.total;
                this.isLoading = false;
            })
            .catch(e =>{
                this.isLoading = false;
            })
        },
        showMore(){
            this.page++;
            axios.get(`${this.auth_data.baseUrl}/api/p/${this.post.id}/comments?api_token=${this.auth_data.api_token}&page=${this.page}`)
                .then(res =>{
                    res.data.data.forEach(e => this.comments.push(e));
                    this.isShowMore = this.comments.length < res.data.total;
                })
                .catch(e =>{
                })
        },
        deleteComment(cmt){
            for (var index in this.comments){
                if (this.comments[index].id === cmt.id){
                    this.$delete(this.comments,index);
                    break;
                }
            }
        }
    }
}
</script>

<style >
 .box-comments .comment:last-child{
     padding-bottom: 25px;
 }
</style>
