<template>
    <div class="box-comments d-flex w-100 p-2 overflow-auto mh-100 position-absolute flex-column flex-nowrap">
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
                this.isLoading = false;
            })
            .catch(e =>{
                this.isLoading = false;
            })
        }
    }
}
</script>

<style scoped>

</style>
