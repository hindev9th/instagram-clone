<template>
    <div class="card chat-app" v-if="getChats">
        <div id="plist" :class="'people-list h-100 border-right ' + (selected_id === 0 ? 'open' : '')">
            <div class="input-group d-flex justify-content-between" style="padding: 20px">
                <h3>Messages</h3>
                <NewButton></NewButton>
            </div>
            <ul class="list-unstyled chat-list mt-2 mb-0" >
                <div class="d-flex justify-content-center align-items-center w-100 h-100" v-if="getChats.total === 0">
                    <span>Not messages found.</span>
                </div>
                <li :class="[{active : $route.params.id === chat.id}]"
                    @click="$router.push({name: 'message', params : {id : chat.id}}).catch(()=>{})"
                    v-for="chat in getChats.data" v-if="getAuth && getAuth.profile">
                    <div class="avatars rounded-circle">
                        <img :src="getImage(user.profile.image)" v-if="user.id !== getAuth.id"
                             v-for="user in chat.users" class="img-avatar" alt="avatar">
                    </div>
                    <div class="about">
                        <div class="name" v-text="chat.name ? chat.name : getNames(chat.users,getAuth)"></div>
                        <!--                            <div class="status"> <i class="fa fa-circle online"></i> online </div>-->
                    </div>
                </li>
                <infinite-loading @infinite="infiniteHandle"></infinite-loading>

            </ul>
        </div>
    </div>

</template>
<script>
import NewButton from "./NewButton";
import {getImage, getNames} from "../../functiton";
import ChatMessage from "./ChatMessage";
import $ from 'jquery';
import {mapActions, mapGetters} from "vuex";

export default {
    components: {NewButton, ChatMessage},
    data() {
        return {
            messages: [],
            chat_id: 0,
            selected_id: 0,
            total : 0,
            page : 1,
        }
    },
    created() {
        this.fetchChats(this.page).then(() => {
            Echo.private(`user.${this.getAuth.id}`)
                .listen('NewChat', (e) => {
                    if (this.getChats.total === 0){
                        this.fetchChats(this.page);
                    }else {
                        this.addNewChat(e);
                    }
                });
        });

    },
    mounted() {
    },
    computed:{
        ...mapGetters('chat',['getChats']),
        ...mapGetters('auth',['getAuth']),
    },
    methods: {
        getImage, getNames,
        ...mapActions('chat',['addNewChat','fetchChats']),
        closeMessage(){
            this.selected_id = 0;
        },
        showMessage(chat) {
            this.selected_id = chat.id;
        },
        infiniteHandle($state){
            this.page++;
            this.fetchChats(this.page).then(()=>{
                if (this.page >= this.getChats.last_page){
                    $state.complete();
                }else {
                    $state.loaded();
                }
            })
        }

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
