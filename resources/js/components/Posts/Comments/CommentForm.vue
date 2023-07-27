<template>
    <div class="box-comment-form">
        <div class="pt-1 w-100">
            <div class="title" v-if="replyComment != null">
                <label for="comment" class="m-0" v-html="extractTagsFromString(`Replying to @${replyComment.user.username} comment`)"></label>
                <span class="text-primary prevent-select cursor-pointer" @click="cancelReply" >Cancel</span>
            </div>
            <form method="post" @submit.prevent="addComment">
                <div class="d-flex">
                    <input id="comment" type="text"
                           class="comment form-control border-0 p-0"
                           v-model="strComment"
                           name="comment" required
                           :readonly="isSending"
                           autocomplete="comment"
                           placeholder="Add a comment"
                           style="background-color: #f8fafc">


                    <button class="btn bg-base" v-if="strComment.length > 0" :disabled="isSending">Post</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {extractTagsFromString} from "../../../functiton";
export default {
    name: "CommentForm",
    props : ['post'],
    data(){
        return{
            strComment : '',
            replyComment : null,
            auth_data : window.Laravel,
            isSending : false,
            isReply : false,
        }
    },
    mounted() {
      Bus.$on('open-reply-comment',comment =>{
          if (this.post.id === comment.post_id){
              this.replyComment = comment;
              this.strComment = `@${comment.user.username} `;
          }
      });

      Bus.$on('cancel-reply', comment =>{
            if (this.post.id === comment.post_id){
                this.cleanReplyComment();
            }
      });
    },
    methods:{
        extractTagsFromString,
        addComment(){
            let data = new FormData();
            data.append('_token',this.auth_data.csrf_token);
            data.append('comment',this.strComment);
            if (this.replyComment != null){
                data.append('parent_id',this.replyComment.id);
            }


            this.isSending = true
            axios.post(`${this.auth_data.baseUrl}/api/p/${this.post.id}/comments?api_token=${this.auth_data.api_token}`,data)
                .then(res =>{
                    this.strComment = '';
                    this.isSending = false;
                    if (this.replyComment != null){
                        Bus.$emit(`reply-comment`,res.data);
                        this.cancelReply();
                    }else {
                        Bus.$emit(`new-comment-${this.post.id}`,res.data);
                    }
                })
                .catch(e =>{
                    this.isSending = false;
                })
        },
        cancelReply(){
            Bus.$emit('cancel-reply',this.replyComment);
        },
        cleanReplyComment(){
            this.replyComment = null;
            this.strComment = '';
        }
    }
}
</script>

<style scoped>

</style>
