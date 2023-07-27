<template>
    <div class="box-comment-form">
        <div class="pt-1 w-100">
            <label for="comment-edit">Editing this comment</label>
            <span class="text-primary prevent-select cursor-pointer" @click="$emit('close-edit-form')" >Cancel</span>
            <form method="post" @submit.prevent="updateComment">
                <div class="d-flex">
                    <input id="comment-edit" type="text"
                           class="comment form-control border-0 p-2"
                           v-model="strComment"
                           name="comment" required
                           :readonly="isSending"
                           autocomplete="comment"
                           placeholder="Add a comment"
                           style="background-color: #f8fafc">


                    <button class="btn bg-base" v-if="strComment.length > 0 && strComment !== comment.comment" :disabled="isSending">Post</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditCommentForm",
    props : ['comment'],
    data(){
        return{
            strComment : this.comment.comment,
            auth_data : window.Laravel,
            isSending : false,
        }
    },
    methods:{
        updateComment(){
            let data = new FormData();
            data.append('_token',this.auth_data.csrf_token);
            data.append('_method','PATCH');
            data.append('comment',this.strComment);

            this.isSending = true
            axios.post(`${this.auth_data.baseUrl}/api/p/comments/${this.comment.id}?api_token=${this.auth_data.api_token}`,data)
                .then(res =>{
                    this.$emit(`edit-comment`,res.data);
                    this.$emit('close-edit-form');
                    this.strComment = '';
                    this.isSending = false;
                })
                .catch(e =>{
                    this.isSending = false;
                })
        }
    }
}
</script>

<style scoped>

</style>
