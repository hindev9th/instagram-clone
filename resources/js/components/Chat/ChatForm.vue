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
        props : ['user'],
        data(){
            return{
                message : '',
                userData: JSON.parse(this.user),
            }
        },
        methods : {
            sendMessage(){
                console.log(this.user);
                this.$emit('messagesent', {
                    user: this.userData,
                    message: this.message
                });
                this.message = '';
            }
        }
    }
</script>
