<template>
    <div id="info-message" class="border-left shadow-sm">
        <div class="header-info border-bottom pt-3 pb-3">
            <button class="btn" @click="$emit('close-info')">&times</button>
            <div class="avatars rounded-circle" v-if="auth">
                <img :src="getImage(user.profile.image)" v-if="auth.id !== user.id" class="img-avatar" v-for="user in chat.users" alt="">
            </div>
            <div class="box-name">
                <strong class="name pt-2 pr-2">{{chat.name == null ?  getNames(chat.users,auth) : chat.name}}</strong>
            </div>
        </div>
        <div class="body-info">
            <div class="item hover-dark-20 cursor-pointer" @click="rename">
                <span>Change name</span>
            </div>
            <div class="item">
                <div class="title d-flex justify-content-between">
                    <span>Members</span>
                    <span class="cursor-pointer prevent-select text-primary">Add</span>
                </div>
                <div class="users pt-2 pb-2">
                    <div class="user pt-2 pb-2 d-flex" v-for="user in chat.users">
                        <img :src="getImage(user.profile.image)" class="avatar" alt="">
                        <div class="name d-flex flex-column">
                            <strong>{{user.name}}</strong>
                            <small>{{user.username}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item text-danger hover-dark-20 cursor-pointer" v-if="chat.users.length > 2" @click="leaveRoom">
                <span>Leave room</span>
            </div>
            <div class="item text-danger hover-dark-20 cursor-pointer" @click="deleteRoom">
                <span>Delete room</span>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage, getNames, showNotify} from "../../../functiton";
import {mapActions, mapGetters} from "vuex";
export default {
    name: "InfoSlide",
    props: ['chat'],
    computed : {
        ...mapGetters('user',{
            auth : "getAuth",
        })
    },
    methods: {
        getImage, getNames,
        ...mapActions('chat',['updateChat','leaveChat','deleteChat']),
        rename(){
            let name = prompt("Input new name chat room!");
            if (!(name == null || name === "")){
                this.chat.name = name;
                this.updateChat(this.chat).then(()=>{
                    showNotify("Rename success!");
                })
            }
        },
        leaveRoom(){
            if (confirm("Are you sure leave this room ?")){
                this.leaveChat(this.chat).then(()=>{
                    showNotify("You left room!")
                    this.$router.push({name : 'chat'});
                })
            }
        },
        deleteRoom(){
            if (confirm("Are you sure delete this room ?")){
                this.deleteChat(this.chat).then(()=>{
                    showNotify("You deleted room!")
                    this.$router.push({name : 'chat'});
                })
            }
        }
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
