import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_MESSAGE} from "../api/messageApi";
import $api from "../api";

Vue.use(Vuex);

const messageStore = {
    namespaced : true,
    state : {
        messages : [],
        message : {},
    },
    mutations : {
        FETCH_MESSAGES(state,messages){
            state.messages = messages;
        },
        FETCH_MESSAGE(state,message){
            state.message = message;
        },
        ADD_MESSAGE(state,message){
            state.messages.data.unshift(message);
        }
    },
    getters :{
        getMessages(state){
            return state.messages;
        },
        getMessage(state){
            return state.message;
        }
    },
    actions : {
        async fetchMessages({commit},chatId){
            await $api.get(`${RESOURCE_MESSAGE}/${chatId}`)
                .then(res => {
                    commit('FETCH_MESSAGES',res.data);
                })
        },
        async fetchMessage({commit}){
            await $api.get(RESOURCE_MESSAGE)
                .then(res =>{
                    commit('FETCH_MESSAGE',res.data);
                })
        },
        async addNewMessageHandle({commit}, {chatId,message}){
            let res = await $api.post(`${RESOURCE_MESSAGE}`,
                {
                    chat_id : chatId,
                    message : message
                });
        },
        addNewMessage({commit},message){
            commit('ADD_MESSAGE',message)
        }
    }
}

export default messageStore;
