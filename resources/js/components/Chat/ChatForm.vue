<template>
    <div class="chat-message clearfix">
        <div class="input-group mb-0">
            <input type="text" class="form-control" v-model="message" placeholder="Enter text here...">
            <div class="input-group-append">
                <button class="pr-4 pl-4 input-group-text" @click="sendMessage"><i class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props : ['chat','user'],
        data(){
            return{
                message : '',
                userData: JSON.parse(this.user),
            }
        },
        methods : {
            sendMessage(){
                if (this.message.length > 0){
                    this.$emit('messagesent', {
                        chat_id : this.chat.id,
                        user_id: this.userData.id,
                        message: this.message,
                        created_at : Date.now()
                    });
                    this.message = '';
                }
            }
        }
    }
</script>
