import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_CHATS} from "../api/chatApi";
import $api from "../api";

Vue.use(Vuex);

const chatStore = {
    namespaced : true,
    state : {
        chats : [],
        chat : {},
    },
    mutations : {
        FETCH_CHATS(state,chats){
            state.chats = chats;
        },
        FETCH_CHAT(state,chat){
            state.chat = chat;
        },
        ADD_CHATS(state,chat){
            state.chats.data.unshift(chat);
        }
    },
    getters :{
        getChats(state){
            return state.chats;
        },
        getChat(state){
            return state.chat;
        },
    },
    actions : {
        async fetchChats({commit}){
            await $api.get(RESOURCE_CHATS)
                .then(res => {
                    commit('FETCH_CHATS',res.data);
                })
        },
        async fetchChat({commit},id){
            let res = await $api.get(`${RESOURCE_CHATS}/${id}`)
            commit('FETCH_CHAT',res.data);
        },
        async addNewChatHandle({commit},usersId){
            let res = await $api.post(`${RESOURCE_CHATS}`,{users : usersId});
        },
        addNewChat({commit},chat){
            commit('ADD_CHATS',chat)
            console.log(chat)
        }
    }
}

export default chatStore;
