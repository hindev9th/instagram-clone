import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_CHATS} from "../api/chatApi";
import $api from "../api/apiClient";

Vue.use(Vuex);

const chatStore = {
    namespaced : true,
    state : {
        chats : {
            data : [],
            total : 0
        },
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
            chats.data.forEach(e => state.chats.data.splice(0,0,e));
        },
        ADD_CHAT(state,chat){
            state.chats.data.unshift(chat);
        },
        REMOVE_CHAT(state,chat){
            for (let i = 0; i < state.chats.data.length; i++){
                if (state.chats.data[i].id === chat.id){
                    state.chats.data.splice(i,1);
                    break;
                }
            }
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
            return res.data;
        },
        addNewChat({commit},chat){
            commit('ADD_CHAT',chat)
        },
        async getChatId({},userIds){
            let res = await $api.post(`${RESOURCE_CHATS}/c`,{
                ids : userIds
            });
            return res.data.id
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
        },
        removeChat({commit},chat){
            commit('REMOVE_CHAT',chat);
        }

    }
}

export default chatStore;
