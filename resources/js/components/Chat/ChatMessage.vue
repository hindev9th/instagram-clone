<template>
    <div class="chat-message">
        <div class="box-message">
            <div class="chat-header d-flex justify-content-between align-items-center">
                <div class="close-message" @click="$emit('close-message')">
                    <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 448 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                    </svg>
                </div>
                <div class="box-name">
                    <div class="avatars rounded-circle">
                        <img :src="getImage(chatUser.profile.image)" v-if="chatUser.id !== user.id"
                             v-for="chatUser in chat.users" class="img-avatar" alt="avatar">
                    </div>
                    <div class="chat-about d-flex align-items-center">
                        <h4 class="m-b-0 m-0 font-weight-bold">
                            {{ getNames(chat.users, user) }}</h4>
                    </div>
                </div>
                <div class="hidden-sm text-right">
                    <!--                        <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>-->
                    <!--                        <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>-->
                    <!--                        <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>-->
                    <a href="javascript:void(0);" class="icon"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>
            <div class="chat-history border-0 position-relative">
                <div class="loading position-absolute w-100 h-100" v-if="isLoading">
                    <div class="spinner-border text-light"></div>
                </div>
                <ul class="m-b-0 m-0 p-3 message-list" id="message-list">
                    <li :class="{'text-right' : message.user_id === user.id}" v-for="message in messages">
                        <div :class="'message-data d-flex '+ (message.user_id !== user.id ? '' : 'justify-content-end')">
                            <img v-if="message.user_id !== user.id"
                                 :src="getImage( message.user.profile.image)"
                                 class="rounded-circle" alt="avatar">
                            <div class="message-name d-flex flex-column pl-2">
                                <strong v-if="message.user_id !== user.id">{{ message.user.name }}</strong>
                                <span class="message-data-time">{{ formatTime(message.created_at) }}</span>
                            </div>
                        </div>
                        <div :class="'message ' + (message.user_id !== user.id ? 'my-message' : 'other-message') ">
                            {{ message.message }}
                        </div>
                    </li>
                    <li class="typing d-flex justify-content-center" v-if="isTyping">
                        {{typingName}}
                        typing
                        <div id="wave">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
        <ChatForm :chat="chat" :user="user"></ChatForm>

    </div>

</template>
<script>
import $ from 'jquery';
import ChatForm from './ChatForm.vue';
import {formatTime, getImage, getNames} from "../../functiton";

export default {
    components: {ChatForm},
    props: ['user', 'chat'],
    data() {
        return {
            messages: [],
            mss: [],
            isLoading: true,
            typingName: '',
            isTyping : false,
        }
    },
    created() {
        Echo.private('chat.' + this.chat.id)
            .listen('NewMessage', (e) => {
                this.messages.push(e)
            })
            .listenForWhisper('typing', (e) =>{
                this.isTyping = e.typing;
                this.typingName = e.name;

                setTimeout( () => {
                    this.isTyping = false;
                }, 1000)
            })


    },
    mounted() {
        this.fetchMessages();

        Bus.$on('NewMessage', (message) => {
            this.messages.push(message);
        })

    },
    methods: {
        formatTime,
        getImage,
        getNames,
        autoScrollBottom() {
            var element = document.getElementById("message-list");
            element.scrollTop = element.scrollHeight;
        },

        fetchMessages() {
            axios.get(window.Laravel.baseUrl + '/c/message/' + this.chat.id)
                .then(response => {
                    this.messages = response.data;
                    this.isLoading = false;
                })
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
