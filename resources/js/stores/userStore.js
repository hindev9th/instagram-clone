import Vue from "vue";
import Vuex from "vuex";
import {AUTH_USER,USER_SUGGESTED} from "../api/userApi";
import $api from "../api";
import {RESOURCE_PROFILES} from "../api/profileApi";

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
            let auth = await $api.get(AUTH_USER)
            commit('FETCH_AUTH',auth.data);
        },
        async fetchSuggested({commit}){
            let users = await $api.get(USER_SUGGESTED)
            commit('FETCH_SUGGESTED',users.data);
        },
        async updateUser({commit},user){
            await $api.post(AUTH_USER,user)
        },
        async changePassword({},password){
            return  await $api.post(AUTH_USER,password);
        },
        async logOut({}){
            await $api.post('/logout').then(()=>{
                location.reload();
            })
        }
    }
}

export default userStore;
