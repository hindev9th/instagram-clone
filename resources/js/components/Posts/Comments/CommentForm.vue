<template>
    <div class="box-comment-form">
        <div class="pt-1 w-100">
            <div class="title" v-if="replyComment != null">
                <label for="comment" class="m-0" v-html="extractTagsFromString(`Replying to @${replyComment.user.username} comment`)"></label>
                <span class="text-primary prevent-select cursor-pointer" @click="cancelReply" >Cancel</span>
            </div>
            <form method="post" @submit.prevent="addHandle">
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
import {mapActions} from "vuex";
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
    computed:{

    },
    methods:{
        ...mapActions('comment',['addComment']),
        extractTagsFromString,
        addHandle(){
            let data = new FormData();
            data.append('post_id',this.post.id);
            data.append('comment',this.strComment);
            if (this.replyComment){
                data.append('parent_id',this.replyComment.parent_id ? this.replyComment.parent_id : this.replyComment.id );
            }


            this.isSending = true
            this.addComment( data)
                .then(res =>{
                    Bus.$emit(`new-comment-${this.post.id}`,res.data);
                    this.strComment = '';
                    this.isSending = false;
                    if (this.replyComment){
                        this.cancelReply();
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
