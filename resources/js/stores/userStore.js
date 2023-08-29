import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_USER,USER_SUGGESTED} from "../api/userApi";
import $api from "../api/apiClient";

Vue.use(Vuex);

const userStore = {
    namespaced : true,
    state : {
        suggested : {},
        search : [],
    },
    mutations : {
        FETCH_SUGGESTED(state,suggested){
            state.suggested = suggested;
        },
        FETCH_SEARCH(state,search){
            state.search = search;
        }
    },
    getters :{
      getAuth(state){
          return state.auth;
      }
    },
    actions : {
        async fetchSuggested({commit}){
            let users = await $api.get(USER_SUGGESTED)
            commit('FETCH_SUGGESTED',users.data);
        },
        async showUser({commit},username){
            return  await $api.get(`${RESOURCE_USER}/${username}`)
        },
        async updateUser({commit},user){
            await $api.post(RESOURCE_USER,user)
        },
        async changePassword({},password){
            return  await $api.post(RESOURCE_USER,password);
        },
    }
}

export default userStore;
