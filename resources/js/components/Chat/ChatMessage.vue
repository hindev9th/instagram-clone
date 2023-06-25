<template>
    <div class="box-message h-100">
        <div class="chat-header clearfix">
            <div class="row">
                <div class="col-lg-6">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                    </a>
                    <div class="chat-about">
                        <h6 class="m-b-0">Aiden Chavez</h6>
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
                    <div v-if="message.user.id === userData.id">
                        <div class="message-data">
                            <span class="message-data-time">10:12 AM, Today</span>
                        </div>
                        <div class="message my-message"> {{ message.message }} </div>
                    </div>
                    <div v-else>
                        <div class="message-data text-right">
                            <span class="message-data-time">10:10 AM, Todayss</span>
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                        </div>
                        <div class="message other-message float-right"> {{ message.message }} </div>
                    </div>

                </li>

            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        props : ['messages','user'],
        data(){
            return{
               userData : JSON.parse(this.user),
            }
        },

        methods : {
            autoScrollBottom(){
                var element = document.getElementById("message-list");
                element.scrollTop = element.scrollHeight;
            }
        },
        updated() {
            this.autoScrollBottom();
        },
    }
</script>
<style>
    .message-list{
        max-height: calc(100% - 55px);
        overflow-y: auto;
        overflow-x: hidden;
    }
    .message-list::-webkit-scrollbar{
        /*display: none;*/
    }
</style>
