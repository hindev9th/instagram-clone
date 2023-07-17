<template>
    <div class="card chat-app">
        <div id="plist" :class="'people-list h-100 border-right ' + (selected_id === 0 ? 'open' : '')">
            <div class="input-group d-flex justify-content-between" style="padding: 20px">
                <h3>Messages</h3>
                <NewButton></NewButton>
            </div>
            <ul class="list-unstyled chat-list mt-2 mb-0">
                <li :class="'d-flex flex-nowrap' + (chat_id === chat.id ? 'active' : '')"
                    @click="showMessage(chat);"
                    v-for="chat in chatsData">
                    <div class="avatars rounded-circle">
                        <img :src="getImage(chatUser.profile.image)" v-if="chatUser.id !== auth_user.id"
                             v-for="chatUser in chat.users" class="img-avatar" alt="avatar">
                    </div>
                    <div class="about">
                        <div class="name" v-text="chat.name == null ? getNames(chat.users,auth_user) : chat.name"></div>
                        <!--                            <div class="status"> <i class="fa fa-circle online"></i> online </div>-->
                    </div>
                </li>
            </ul>
        </div>
        <div class="chat-messge non-message w-100 flex-column justify-content-center align-items-center" v-if="selected_id === 0">
            <i class="far fa-comment-dots icon" style="font-size: 40px"></i>
            <h4 class="font-weight-bold">Your messages</h4>
            <span>Send private messages to your friend or group</span>
            <button class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                    data-target="#modal-new">Send message</button>
        </div>
        <ChatMessage :chat="chat" :user="auth_user" :class="{'open' : (chat.id === selected_id)}" @close-message="closeMessage" v-if="chat.id === selected_id" v-for="chat in chatsData"
                     :key="chat.id"></ChatMessage>
    </div>

</template>
<script>
import NewButton from "./NewButton";
import {getImage, getNames} from "../../functiton";
import ChatMessage from "./ChatMessage";
import $ from 'jquery';

export default {
    components: {NewButton, ChatMessage},
    props: ['chats', 'user'],
    data() {
        return {
            messages: [],
            chatsData: JSON.parse(this.chats),
            auth_user: JSON.parse(this.user),
            chat_id: 0,
            selected_id: 0,
        }
    },
    created() {
        Echo.private('user.' + this.auth_user.id)
            .listen('NewChat', (e) => {
                this.chatsData.unshift({
                    'id': e.id,
                    'name': e.name,
                    'users': e.users,
                });
            });

        $('.menu-app').addClass('small');
    },
    mounted() {
      Bus.$on('NewChatRoom', (chat) => {
          this.chatsData.unshift(chat);
          this.selected_id = chat.id;
      })
    },
    methods: {
        getImage,
        getNames,
        closeMessage(){
            this.selected_id = 0;
        },
        showMessage(chat) {
            this.selected_id = chat.id;
        },


    }
}
</script>
<style>

.chat {
    height: calc(100% - 100px);
}

.chat-list {
    height: calc(100% - 87px);
    overflow-y: auto;
.about {
    width: calc(100% - 20px);

.name {
    white-space: nowrap;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
}

}

}
.non-message{
    display: flex;
}
@media (max-width: 767px) {
    .non-message{
        display: none;
    }
}

@media (min-width: 768px) {
    .chat-main {
        width: calc(100% - 66px);
    }
}
</style>
