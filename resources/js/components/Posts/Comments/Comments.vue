<template>
    <div class="box-comments d-flex w-100 mt-2 pl-2 pr-2 overflow-auto mh-100 position-absolute flex-column flex-nowrap">
        <div class="d-flex mb-2">
            <div class="pr-1">
                <img :src="getImage(post.user.profile.image)"
                     class="avatar rounded-circle" alt="">
            </div>
            <div class="pl-2">
                <a :href="base_url + '/profile/' + post.user.username"
                   class="text-decoration-none text-dark"><strong>{{post.user.username}}</strong></a>
                {{ post.caption }}
                <div class="time">
                    {{ formatTime(post.created_at) }}
                </div>
            </div>
        </div>
        <Comment :comment="comment" :user="user" v-for="comment in comments" :key="comment.id"></Comment>
        <button class="btn btn-outline-secondary m-5" @click="showMore" v-if="isShowMore">Show more</button>
    </div>
</template>

<script>
import {getImage,formatTime} from "../../../functiton";
import Comment from './Comment.vue';
export default {
    components: {Comment},
    name: "Comments",
    props: ['post','user'],
    data(){
        return{
            comments : [],
            isLoading : false,
            base_url : window.Laravel.baseUrl,
            page : 1,
            isShowMore: false,
        }
    },
    created() {
        this.fetchComments();
    },
    mounted() {
        Bus.$on('NewComment', comment =>{
            this.comments.push(comment);
        })
    },
    methods:{
        getImage,formatTime,
        fetchComments(){
            this.isLoading = true;
            axios.get(`${this.base_url}/api/p/${this.post.id}/comment`)
            .then(res =>{
                this.comments = res.data.data;
                this.isShowMore = res.data.data.length > 4;
                this.isLoading = false;
            })
            .catch(e =>{
                this.isLoading = false;
            })
        },
        showMore(){
            this.page++;
            axios.get(`${this.base_url}/api/p/${this.post.id}/comment?page=${this.page}`)
                .then(res =>{
                    res.data.data.forEach(e => this.comments.push(e));
                    this.isShowMore = res.data.data.length > 4;
                })
                .catch(e =>{
                })
        }
    }
}
</script>

<style >
 .box-comments .comment:last-child{
     padding-bottom: 25px;
 }
</style>
