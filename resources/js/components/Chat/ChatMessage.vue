<template>
    <div class="box-message h-100">
        <div class="chat-header clearfix">
            <div class="row">
                <div class="col-lg-6">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                        <img
                            :src="getImage( chat.user_id === userData.id ? chat.profile.image : chat.user.profile.image)"
                            class="rounded-circle border" alt="avatar">
                    </a>
                    <div class="chat-about">
                        <h6 class="m-b-0">
                            {{ chat.user_id === userData.id ? chat.profile.user.username : chat.user.username }}</h6>
                        <small>Last seen: 2 hours ago</small>
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
        <div class="chat-history h-100">
            <ul class="m-b-0 message-list h-100" id="message-list">
                <li class="clearfix" v-for="message in messages">
                    <div v-if="message.user_id === userData.id">
                        <div class="message-data text-right">
                            <span class="message-data-time">{{ formatTime(message.created_at) }}</span>
                        </div>
                        <div class="message other-message float-right"> {{ message.message }}</div>
                    </div>
                    <div v-else>
                        <div class="message-data">
                            <img
                                :src="getImage( chat.user_id === userData.id ? chat.profile.image : chat.user.profile.image)"
                                class="rounded-circle border" alt="avatar">
                            <span class="message-data-time">{{ formatTime(message.created_at) }}</span>
                        </div>
                        <div class="message my-message"> {{ message.message }}</div>
                    </div>

                </li>

            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props: ['messages', 'user', 'chat', 'action'],
    data() {
        return {
            userData: JSON.parse(this.user),
        }
    },
    methods: {
        autoScrollBottom() {
            var element = document.getElementById("message-list");
            element.scrollTop = element.scrollHeight;
        },

        getImage(image) {
            return image == null ? 'https://t3.ftcdn.net/jpg/01/18/01/98/360_F_118019822_6CKXP6rXmVhDOzbXZlLqEM2ya4HhYzSV.jpg' : this.action + '/storage/' + image;
        },
        formatTime(time) {
            const startTime = new Date(time);
            const endTime = new Date();
            const seconds = Math.floor((endTime - startTime) / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            const weeks = Math.floor(days / 7);
            const months = Math.floor(days / 30);
            const years = Math.floor(months / 12);

            if (seconds < 0) {
                return startTime.toLocaleString();
            }

            if (seconds < 60) {
                return `${seconds} seconds ago`;
            }

            if (minutes < 60) {
                return `${minutes} minutes ago`;
            }

            if (hours < 24) {
                return `${hours} hours ago`;
            }

            if (days < 7) {
                return `${days} days ago`;
            }

            if (days < 30) {
                return `${weeks} weeks ago`;
            }

            if (months < 12) {
                return `${months} months ago`;
            }

            return `${years} years ago`;
        }
    },
    updated() {
        this.autoScrollBottom();
    },
}
</script>
<style>
.message-list {
    max-height: calc(100% - 55px);
    overflow-y: auto;
    overflow-x: hidden;
}

.message-list::-webkit-scrollbar {
    /*display: none;*/
}
</style>
