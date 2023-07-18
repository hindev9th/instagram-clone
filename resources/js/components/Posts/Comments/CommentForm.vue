<template>
    <div class="box-comment-form">
        <div class="pt-1 w-100">
            <form method="post" @submit.prevent="addComment">
                <div class="d-flex">
                    <input id="comment" type="text"
                           class="comment form-control border-0 p-0"
                           v-model="comment"
                           name="comment" required
                           :readonly="isSending"
                           autocomplete="comment"
                           placeholder="Add a comment"
                           style="background-color: #f8fafc">


                    <button class="btn " v-if="comment.length > 0" :disabled="isSending">Post</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "CommentForm",
    props : ['user','post'],
    data(){
        return{
            comment : '',
            base_url : window.Laravel.baseUrl,
            isSending : false,
        }
    },
    methods:{
        addComment(){
            let data = new FormData();
            data.append('_token',window.Laravel.csrf_token);
            data.append('user_id',this.user.id);
            data.append('comment',this.comment);

            this.isSending = true
            axios.post(this.base_url + '/api/p/' + this.post.id + '/comment',data)
                .then(res =>{
                    Bus.$emit('NewComment',res.data);
                    this.comment = '';
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
