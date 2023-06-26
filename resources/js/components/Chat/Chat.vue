<template>
    <div class="card chat-app">
        <div id="plist" class="people-list">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Search...">
            </div>
            <ul class="list-unstyled chat-list mt-2 mb-0">
                <li :class="'clearfix ' + (chat_id === chat.id ? 'active' : '')" @click="showMessage(chat);" v-for="chat in chatsData">
                    <div v-if="chat.user_id === userData.id">
                        <img :src="getImage(chat.profile.image)" alt="avatar">
                        <div class="about">
                            <div class="name">{{ chat.profile.user.username }}</div>
                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                        </div>
                    </div>
                    <div v-else>
                        <img :src="getImage(chat.user.profile.image)" alt="avatar">
                        <div class="about">
                            <div class="name">{{ chat.user.username }}</div>
                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
        <div class="chat" v-if="isShow">
            <chat-message :messages="messages" :chat="chat" :action="action" :user="user"></chat-message>
            <chat-form :chat="chat" v-on:messagesent="addMessage"
                       :user="user"></chat-form>
        </div>
    </div>

</template>
<script>
    export default {
        props : ['action','chats','user'],
        data() {
            return{
                messages: [],
                chatsData : JSON.parse(this.chats),
                userData: JSON.parse(this.user),
                chat_id : 0,
                chat : null,
                isShow : false,
            }
        },
        created() {

        },
        methods: {
            addMessage(message) {
                this.messages.push(message);

                axios.post(this.action + '/c/message/' + this.chat.id, message).then(response => {
                    //this.messages.push(response.data);
                });
            },
            fetchMessages() {
                axios.get(this.action + '/c/message/' + this.chat.id).then(response => {
                    this.messages = response.data;
                });
            },
            listenForNewMessage(){
                Echo.private('chat.' + this.chat_id)
                    .listen('MessageSent', (e) => {
                        this.messages.push({
                            chat : e.message.chat,
                            message: e.message.message,
                            user: e.user
                        });
                    });
            },
            showMessage(chat){
                this.chat = chat;
                this.chat_id = chat.id;
                this.isShow = true;
                this.fetchMessages();
                this.listenForNewMessage();
                console
            },

            getImage(image){
                return image == null ? 'https://t3.ftcdn.net/jpg/01/18/01/98/360_F_118019822_6CKXP6rXmVhDOzbXZlLqEM2ya4HhYzSV.jpg' : this.action + '/storage/' + image;
            },
            update() {
                console.log('tets');
            }
        }
    }
</script>
<style>
    .chat{
        height: calc(100% - 100px);
    }
</style>
