import Vue from "vue";
import Vuex from "vuex";
import {AUTH_USER,SUGGESTED_USER,SEARCH_USER} from "../api/userApi";
import $api from "../api";

Vue.use(Vuex);

const userStore = {
    namespaced : true,
    state : {
        auth : {},
        suggested : {},
        search : [],
    },
    mutations : {
        FETCH_AUTH(state,auth){
            state.auth = auth;
        },
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
        async fetchAuth({commit}){
            await $api.get(AUTH_USER)
                .then(res => {
                    commit('FETCH_AUTH',res.data);
                })
        },
        async fetchSuggested({commit}){
            await $api.get(SUGGESTED_USER)
                .then(res =>{
                    commit('FETCH_SUGGESTED',res.data);
                })
        },
        async logOut({commit}){
            await $api.post('/logout')
                .then(res => {
                    location.reload();
                })
        }
    }
}

export default userStore;
