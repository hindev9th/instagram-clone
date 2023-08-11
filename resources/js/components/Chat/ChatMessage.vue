<template>
    <div class="chat-message h-100" v-if="">
        <div class="box-message">
            <div class="chat-header border-bottom d-flex justify-content-between align-items-center">
                <div class="close-message" @click="$emit('close-message')">
                    <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 448 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                    </svg>
                </div>
                <div class="box-name">
                    <div class="avatars rounded-circle">
                        <img :src="getImage(user.profile.image)" v-if="user.id !== auth.id"
                             v-for="user in chat.users" class="img-avatar" alt="avatar">
                    </div>
                    <div class="chat-about d-flex align-items-center">
                        <h4 class="name m-b-0 m-0 font-weight-bold">
                            {{ getNames(chat.users, auth) }}</h4>
                    </div>
                </div>
                <div class="hidden-sm text-right">
                    <a href="javascript:void(0);" @click="showAndHideInfo" class="icon"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>
            <div class="chat-history border-0 position-relative">
                <div class="loading position-absolute w-100 h-100" v-if="isLoading">
                    <div class="spinner-border text-light"></div>
                </div>
                <ul class="m-b-0 m-0 p-3 message-list" id="message-list">
                    <li class="typing d-flex justify-content-center mb-0" v-if="isTyping">
                        {{typingName}}
                        typing
                        <div id="wave">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </li>
                    <li class="p-5 d-flex justify-content-center align-items-center" v-if="messages.length === 0">
                        <div class="box-name flex-column w-100 align-items-center">
                            <div class="avatars rounded-circle" style="min-width: 100px;min-height: 100px">
                                <img :src="getImage(chatUser.profile.image)" v-if="chatUser.id !== auth.id"
                                     v-for="chatUser in chat.users" class="img-avatar" alt="avatar">
                            </div>
                            <div class="chat-about p-2 d-flex align-items-center">
                                <h4 class="name m-b-0 m-0 font-weight-bold">
                                    {{ getNames(chat.users, auth) }}</h4>
                            </div>
                            <a href="#input-message" class="btn btn-primary">Start chat</a>
                        </div>
                    </li>
                    <li :class="{'text-right' : message.user_id === auth.id}" v-for="message in messages.data">
                        <div :class="'message-data d-flex '+ (message.user_id !== auth.id ? '' : 'justify-content-end')">
                            <img v-if="message.user_id !== auth.id"
                                 :src="getImage( message.user.profile.image)"
                                 class="rounded-circle" alt="avatar">
                            <div class="message-name d-flex flex-column pl-2">
                                <strong v-if="message.user_id !== auth.id">{{ message.user.name }}</strong>
                                <span class="message-data-time">{{ formatTime(message.created_at) }}</span>
                            </div>
                        </div>
                        <div :class="'message ' + (message.user_id !== auth.id ? 'my-message' : 'other-message') ">
                            {{ message.message }}
                        </div>
                    </li>

                </ul>

            </div>
        </div>
        <ChatForm></ChatForm>
        <info-slide :user="auth" :chat="chat" :class="{'show':isShowInfo}" @close-info="showAndHideInfo"></info-slide>
    </div>

</template>
<script>
import $ from 'jquery';
import ChatForm from './ChatForm.vue';
import InfoSlide from "./Slides/InfoSlide";
import {formatTime, getImage, getNames} from "../../functiton";
import {mapActions, mapGetters} from "vuex";

export default {
    components: {ChatForm,InfoSlide},
    data() {
        return {
            mss: [],
            isLoading: true,
            typingName: '',
            isTyping : false,
            isShowInfo : false,
        }
    },
    created() {
        this.fetchChat(this.$route.params.id).then(() => {
            Echo.private('chat.' + this.chat.id)
                .listen('NewMessage', (e) => {
                    this.addNewMessage(e);
                })
                .listenForWhisper('typing', (e) =>{
                    this.isTyping = e.typing;
                    this.typingName = e.name;

                    setTimeout( () => {
                        this.isTyping = false;
                    }, 1000)
                })
        })
        this.fetchMessages(this.$route.params.id)
            .then(() => {
                this.isLoading = false;
            })


    },
    mounted() {

        Bus.$on('NewMessage', (message) => {
            this.messages.push(message);
        })

    },
    computed : {
        ...mapGetters('user',{
            auth : 'getAuth',
        }),
        ...mapGetters('chat',{
            chat : 'getChat'
        }),
        ...mapGetters('message',{
            messages : 'getMessages'
        })
    },
    methods: {
        formatTime,getImage,getNames,
        ...mapActions('chat',['fetchChat']),
        ...mapActions('message',['fetchMessages','addNewMessage']),
        showAndHideInfo(){
            this.isShowInfo = !this.isShowInfo;
        },
        autoScrollBottom() {
            var element = document.getElementById("message-list");
            element.scrollTop = element.scrollHeight;
        },


    },
    updated() {
        this.autoScrollBottom();
    },
}
</script>
<style>
.message-list {
    overflow-y: auto;
    overflow-x: hidden;
}

.message-list::-webkit-scrollbar {
    /*display: none;*/
}
#wave {
    position:relative;
    text-align:center;
.dot {
    display:inline-block;
    width: 3px;
    height: 3px;
    border-radius:50%;
    margin-right:3px;
    background:#303131;
    animation: wave 1.3s linear infinite;

&:nth-child(2) {
     animation-delay: -1.1s;
 }

&:nth-child(3) {
     animation-delay: -0.9s;
 }
}
}

@keyframes wave {
    0%, 60%, 100% {
        transform: initial;
    }

    30% {
        transform: translateY(-10px);
    }
}
</style>
