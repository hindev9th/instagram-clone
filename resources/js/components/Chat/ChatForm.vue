<template>
    <div class="chat-message clearfix">
        <div class="input-group mb-0">
            <input type="text" class="form-control" v-model="message" @keyup.enter="sendMessage" placeholder="Enter text here...">
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
            }
        },
        methods : {
            sendMessage(){
                if (this.message.length > 0){
                    axios.post(window.Laravel.baseUrl+'/c/message/'+this.chat.id,
                        {
                            message : this.message,
                        }
                    ).then(response => {
                        this.message = '';
                        Bus.$emit('NewMessage', response.data);
                    })
                }
            }
        }
    }
</script>
