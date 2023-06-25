<template>
    <div class="chat">
        <chat-message :messages="messages" :user="user"></chat-message>
        <chat-form v-on:messagesent="addMessage"
                   :user="user"></chat-form>
    </div>
</template>
<script>
    export default {
        props : ['action','user'],
        data() {
            return{
                messages: []
            }
        },

        created() {
            this.fetchMessages();
            Echo.private('chat')
                .listen('MessageSent', (e) => {
                    this.messages.push({
                        message: e.message.message,
                        user: e.user
                    });
                });
        },

        methods: {
            fetchMessages() {
                axios.get(this.action).then(response => {
                    this.messages = response.data;
                });
            },

            addMessage(message) {
                this.messages.push(message);

                axios.post(this.action, message).then(response => {
                    console.log(response.data);
                });
            }
        }
    }
</script>
<style>
    .chat{
        height: calc(100% - 100px);
    }
</style>
