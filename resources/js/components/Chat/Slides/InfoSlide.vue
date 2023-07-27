<template>
    <div id="info-message" class="border-left shadow-sm">
        <div class="header-info border-bottom pt-3 pb-3">
            <button class="btn" @click="$emit('close-info')">&times</button>
            <div class="avatars rounded-circle" >
                <img :src="getImage(chatUser.profile.image)" v-if="user.id !== chatUser.id" class="img-avatar" v-for="chatUser in chat.users" alt="">
            </div>
            <div class="box-name">
                <strong class="name pt-2 pr-2">{{chat.name == null ?  getNames(chat.users,user) : chat.name}}</strong>
            </div>
        </div>
        <div class="body-info">
            <div class="item hover-dark-20 cursor-pointer">
                <span>Change name</span>
            </div>
            <div class="item">
                <div class="title d-flex justify-content-between">
                    <span>Members</span>
                    <span>Add</span>
                </div>
                <div class="users pt-2 pb-2">
                    <div class="user pt-2 pb-2 d-flex" v-for="chatUser in chat.users">
                        <img :src="getImage(chatUser.profile.image)" class="avatar" alt="">
                        <div class="name d-flex flex-column">
                            <strong>{{chatUser.name}}</strong>
                            <small>{{chatUser.username}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item text-danger hover-dark-20 cursor-pointer">
                <span>Leave room</span>
            </div>
            <div class="item text-danger hover-dark-20 cursor-pointer">
                <span>Delete room</span>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage,getNames} from "../../../functiton";
export default {
    name: "InfoSlide",
    props: ['user','chat'],
    methods: {
        getImage,
        getNames,
    }
}
</script>

<style scoped>
    #info-message{
        position: fixed;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background: #fff;
        transition: 0.3s;
        z-index: 10;
        margin-right: -100%;
        &.show{
            margin-right: 0;
             transition: 0.3s;
         }
        .btn{
            font-size: 30px;
        }
    }
    .header-info{
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        .btn{
            position: absolute;
            top: 0;
            left: 5px;
        }
        .avatars{
            min-width: 100px;
            min-height: 100px;
        }
        .box-name{
            display: flex;
            font-size: 18px;
            .fa{
                cursor: pointer;
                line-height: 40px;
            }
            .name{
                padding-left: 0.5rem;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        }
    }
    .body-info{
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        max-height: calc(100% - 170px);
        .item{
            padding: 10px;
            &:not(:last-of-type){
                 border-bottom: 1px solid #dee2e6;
             }
        }
    }
    @media (max-width: 767px) {
        #info-message{
            width: 100%;
        }
        .body-info{
            max-height: calc(100% - 250px);
        }
    }
</style>
