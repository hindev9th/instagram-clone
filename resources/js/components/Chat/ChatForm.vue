<template>
    <div class="chat-message input-message">
        <div class="input-group mb-0">
            <input type="text" id="input-message" class="form-control" :readonly="isSending" v-model="message" @keydown="typing" @keyup.enter="sendMessage"
                   placeholder="Enter text here...">
            <div class="input-group-append" :style="(isSending ? bgColor : '')">
                <button class="pr-4 pl-4 input-group-text" v-show="message.length > 0 && !isSending" :disabled="message.length === 0"
                        @click="sendMessage"><i class="fa fa-paper-plane"></i></button>
                <div class="input-loading p-0" v-show="isSending">
                    <div class="icon-load spinner-border text-primary"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions, mapGetters} from "vuex";

export default {
    data() {
        return {
            message: '',
            isSending : false,
            bgColor : {backgroundColor : '#e9ecef',},
        }
    },
    computed : {
        ...mapGetters('user',{
            auth :'getAuth',
        })
    },
    methods: {
        ...mapActions('message',['addNewMessageHandle']),
        sendMessage() {
            if (this.message.length > 0) {
                this.isSending = true;
                this.addNewMessageHandle({chatId : this.$route.params.id,message : this.message})
                .then(response => {
                    this.isSending = false;
                    this.message = '';
                })
                .catch(error => {
                    this.isSending = false;
                })
            }
        },
        typing(){
            let channel = Echo.private('chat.' + this.$route.params.id)

            setTimeout( () => {
                channel.whisper('typing', {
                    name : this.auth.username,
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
         width: 1rem;
         height: 1rem;
     }
 }
</style>
