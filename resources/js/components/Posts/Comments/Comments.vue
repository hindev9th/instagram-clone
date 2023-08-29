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
        <div v-if="getComments && !isLoading">
            <Comment :comment="comment" v-for="comment in getComments.data"  :key="comment.id"></Comment>
            <infinite-loading @infinite="infiniteHandle"></infinite-loading>
        </div>
    </div>
</template>

<script>
import {getImage,formatTime} from "../../../functiton";
import Comment from './Comment.vue';
import {mapActions, mapGetters} from "vuex";
import $api from "../../../api/apiClient";
export default {
    components: {Comment},
    name: "Comments",
    props: ['post'],
    data(){
        return{
            comments : null,
            isLoading : true,
            auth_data : window.Laravel,
            page : 1,
            isShowMore: false,
        }
    },
    created() {
        this.fetchComments({postId : this.post.id,page: this.page}).then(e => {
            this.isLoading = false;
        });
    },
    computed:{
        ...mapGetters('comment',['getComments'])
    },
    methods:{
        getImage,formatTime,
        ...mapActions('comment',['fetchComments']),
        infiniteHandle($state){
            this.page++;
            this.fetchComments({postId: this.post.id, page: this.page})
            .then(e =>{
                if (this.page >= this.getComments.last_page){
                    $state.complete();
                }else {
                    $state.loaded();
                }
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
