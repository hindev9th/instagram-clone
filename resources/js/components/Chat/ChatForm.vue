<template>
    <div class="chat-message input-message">
        <div class="input-group mb-0">
            <input type="text" class="form-control" :readonly="isSending" v-model="message" @keydown="typing" @keyup.enter="sendMessage"
                   placeholder="Enter text here...">
            <div class="input-group-append" :style="(isSending ? bgColor : '')">
                <button class="pr-4 pl-4 input-group-text" v-show="message.length > 0 && !isSending" :disabled="message.length === 0"
                        @click="sendMessage"><i class="fa fa-paper-plane"></i></button>
                <div class="input-loading" v-show="isSending">
                    <div class="icon-load spinner-border text-primary"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['chat', 'user'],
    data() {
        return {
            message: '',
            isSending : false,
            bgColor : {backgroundColor : '#e9ecef',},
        }
    },
    methods: {
        sendMessage() {
            if (this.message.length > 0) {
                this.isSending = true;
                axios.post(window.Laravel.baseUrl + '/c/message/' + this.chat.id,
                    {
                        message: this.message,
                    }
                ).then(response => {
                    this.isSending = false;
                    this.message = '';
                    Bus.$emit('NewMessage', response.data);
                })
                .catch(error => {
                    this.isSending = false;
                })
            }
        },
        typing(){
            let channel = Echo.private('chat.' + this.chat.id)

            setTimeout( () => {
                channel.whisper('typing', {
                    name : this.user.username,
                    typing: true,
                })
            }, 300)
        }
    }
}
</script>
<style scoped>
 .input-group-append{
     width: 50px;
     background-color: #fff;
}
 .input-loading{
     width: 1rem;
     height: 1rem;
     margin: auto;
     .icon-load{
         width: 100%;
         height: 100%;
     }
 }
</style>
