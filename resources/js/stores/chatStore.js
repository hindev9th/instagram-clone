import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_CHATS} from "../api/chatApi";
import $api from "../api";

Vue.use(Vuex);

const chatStore = {
    namespaced : true,
    state : {
        chats : null,
        chat : null,
    },
    mutations : {
        FETCH_CHATS(state,chats){
            state.chats = chats;
        },
        FETCH_CHAT(state,chat){
            state.chat = chat;
        },
        ADD_CHATS(state,chats){
            chats.data.forEach(e => state.chats.data.push(e));
        },
        ADD_CHAT(state,chat){
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
        async fetchChats({commit},page){
            let res =  await $api.get(`${RESOURCE_CHATS}?page=${page}`)
            if (page === 1){
                commit('FETCH_CHATS',res.data);
            }else {
                commit('ADD_CHATS',res.data)
            }
        },
        async fetchChat({commit},id){
            let res = await $api.get(`${RESOURCE_CHATS}/${id}`)
            commit('FETCH_CHAT',res.data);
        },
        async addNewChatHandle({commit},usersId){
            let res = await $api.post(`${RESOURCE_CHATS}`,{users : usersId});
        },
        addNewChat({commit},chat){
            commit('ADD_CHAT',chat)
        },
        async updateChat({commit},chat){
            let res = await $api.post(`${RESOURCE_CHATS}/${chat.id}`,{
                _method : 'PUT',
                name : chat.name
            });
            commit('FETCH_CHAT',chat);
        },
        async leaveChat({commit},chat){
            await $api.post(`${RESOURCE_CHATS}/${chat.id}`,{
                _method : 'PATCH',
            });
        },
        async deleteChat({commit},chat){
            await $api.post(`${RESOURCE_CHATS}/${chat.id}`,{
                _method : 'DELETE',
            });
        }

    }
}

export default chatStore;
