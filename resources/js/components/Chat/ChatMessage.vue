<template>
    <div class="chat-message">
        <div class="box-message">
            <div class="chat-header clearfix">
                <div class="row">
                    <div class="col-lg-6 box-name">
                        <div class="avatars border rounded-circle">
                            <img :src="getImage(chatUser.profile.image)" v-if="chatUser.id !== user.id"
                                 v-for="chatUser in chat.users" class="avatar border" alt="avatar">
                        </div>
                        <div class="chat-about d-flex align-items-center">
                            <h4 class="m-b-0 m-0 font-weight-bold">
                                {{ getNames(chat.users, user) }}</h4>
                        </div>
                    </div>
                    <div class="col-lg-6 hidden-sm text-right">
                        <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                        <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                        <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                        <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                    </div>
                </div>
            </div>
            <div class="chat-history">
                <ul class="m-b-0 m-0 p-3 message-list" id="message-list">
                    <li class="clearfix" v-for="message in messages">
                        <div v-if="message.user_id === user.id">
                            <div class="message-data text-right">
                                <span class="message-data-time">{{ formatTime(message.created_at) }}</span>
                            </div>
                            <div class="message other-message float-right"> {{ message.message }}</div>
                        </div>
                        <div v-else>
                            <div class="message-data d-flex">
                                <img
                                    :src="getImage( message.user.profile.image)"
                                    width="35px" height="35px"
                                    class="rounded-circle border" alt="avatar">
                                <div class="message-name d-flex flex-column pl-2">
                                    <strong>{{ message.user.name }}</strong>
                                    <span class="message-data-time">{{ formatTime(message.created_at) }}</span>
                                </div>
                            </div>
                            <div class="message my-message"> {{ message.message }}</div>
                        </div>

                    </li>

                </ul>
            </div>
        </div>
        <ChatForm :chat="chat" :user="user"></ChatForm>
        {{ mss}}

    </div>

</template>
<script>
import ChatForm from './ChatForm.vue';
import {formatTime, getImage, getNames} from "../../functiton";

export default {
    components: {ChatForm},
    props: ['user', 'chat'],
    data() {
        return {
            messages: [],
            mss : [],
        }
    },
    created() {
        Echo.private('chat.' + this.chat.id)
            .listen('NewMessage', (e) => {
                this.messages.push(e
                )
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
                })
        }
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
</style>
