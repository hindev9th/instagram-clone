<template>
    <div class="comment">
        <div class="d-flex justify-content-between align-items-center w-100" @mouseover="isShowBtnSt = true" @mouseleave="isShowBtnSt = false">
            <div class="box-comment d-flex mt-2 mb-2">
                <div class="pr-1">
                    <img :src="getImage(comment.user.profile.image)"
                         class="avatar rounded-circle" alt="">
                </div>
                <div class="">
                    <a :href="base_url + '/profile/' + comment.user.username"
                       class="text-decoration-none text-dark"><strong>{{comment.user.username}}</strong></a>
                    <span v-html="extractTagsFromString(comment.comment)"></span>
                    <div class="box-action">
                        <span class="time pr-2"> {{ formatTime(comment.created_at) }} </span>
                        <div class="action d-flex">
                            <ShowUserButton :action="`${auth_data.baseUrl}/api/p/comment/${comment.id}/likes`" title="Likes" :text="`${likeCount} Likes`" v-if="likeCount > 0"></ShowUserButton>
                            <span class="prevent-select cursor-pointer text-primary pr-3" @click="reply">Reply</span>
                            <div class="setting-comment" v-if="isShowBtnSt && comment.user_id === getAuth.id">
                                <span class="setting prevent-select cursor-pointer p-2" data-toggle="modal"
                                      data-keyboard="false" data-target="#modal-comment-setting" @click="showAndHide">
                                     <i class="fas fa-ellipsis-v"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <LikeCommentButton :comment="comment" @add-like="addLike" @minus-like="minusLike"></LikeCommentButton>

        </div>
        <div class="replies">
            <EditCommentForm :comment="comment" @close-edit-form="showAndHideEditForm" @edit-comment="editComment" v-if="isShowEditForm"></EditCommentForm>
            <span class="prevent-select cursor-pointer" @click="loadReplies" v-if="repliesCount > 0" v-text="`View replies (${repliesCount})`"></span>
            <comment :comment="reply"  :key="index" v-for="(reply,index) in replies" class="reply p-0"></comment>
        </div>



        <div class="modal fade" v-if="isShowSetting" id="modal-comment-setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content overflow-hidden border-0">
                    <button type="button" @click="showAndHide" class="close position-fixed" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body p-0">
                        <ul class="list-unstyled text-center m-0">
                            <li class="hover-dark-20 p-2 border-bottom  font-weight-bold" @click="showAndHideEditForm(); showAndHide()" data-dismiss="modal">Edit</li>
                            <li class="hover-dark-20 p-2 border-bottom text-danger font-weight-bold" @click="deleteComment();showAndHide()" data-dismiss="modal">Delete</li>
                            <li class="hover-dark-20 p-2 border-bottom" @click="showAndHide" data-dismiss="modal">Cancel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';
import {getImage,formatTime,extractTagsFromString} from "../../../functiton";
import ShowUserButton from "../../User/Buttons/ShowUserButton";
import LikeCommentButton from "./Buttons/LikeCommentButton";
import EditCommentForm from "./EditCommentForm";
import {mapGetters} from "vuex";
export default {
    name: "comment",
    components: {ShowUserButton,LikeCommentButton,EditCommentForm},
    props: ['comment'],
    data(){
        return{
            base_url:window.Laravel.baseUrl,
            auth_data : window.Laravel,
            replies : null,
            isShowSetting : false,
            isShowBtnSt : false,
            isShowEditForm : false,
            likeCount : this.comment.likes_count,
            repliesCount : this.comment.replies_count,
            page : 0,
        }
    },
    computed:{
      ...mapGetters('user',['getAuth']),
    },
    mounted() {
      Bus.$on('reply-comment', reply => {
          if (this.comment.id === parseInt(reply.parent_id)){
              this.replies = [];
              this.replies.push(reply);
          }
      })
    },
    methods:{
        getImage,formatTime,extractTagsFromString,
        loadReplies(){
            axios.get(`${this.auth_data.baseUrl}/api/p/${this.comment.id}/replies?api_token=${this.auth_data.api_token}&page=${this.page}`)
            .then(res => {
                if (this.replies == null){
                    this.replies = res.data.data;
                }else {
                    res.data.data.forEach(e => this.replies.push(e));
                }
                this.repliesCount = res.data.total - this.replies.length;
            })
            .catch(e =>{

            })
        },
        editComment(data){
            this.comment.comment = data.comment;
        },
        deleteComment(){
          axios.post(`${this.auth_data.baseUrl}/api/p/comments/${this.comment.id}?api_token=${this.auth_data.api_token}`,{
              _method : 'DELETE',
          })
            .then(res => {
                Bus.$emit('delete-comment',this.comment);
            })
            .catch(e => {

            })
        },
        reply(){
          Bus.$emit('open-reply-comment',this.comment);
        },
        showAndHideEditForm(){
            this.isShowEditForm = !this.isShowEditForm;
        },
        showAndHide(){
            this.isShowSetting = !this.isShowSetting;
        },
        addLike(){
            this.likeCount++;
        },
        minusLike(){
            this.likeCount--;
        }
    }
}
</script>

<style scoped>
    .setting-comment .setting{
        position: relative;
    }
    .box-action{
        display: flex;
    }
    .replies{
        margin-left: 52px;
    }
</style>
