import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_AUTH} from "../api/authApi";
import $api from "../api/apiClient";

Vue.use(Vuex);

const userStore = {
    namespaced : true,
    state : {
        auth : null,
    },
    mutations : {
        FETCH_AUTH(state,auth){
            state.auth = auth;
        },
    },
    getters :{
        getAuth(state){
            return state.auth;
        }
    },
    actions : {
        async fetchAuth({commit}){
            let auth = await $api.get(RESOURCE_AUTH)
            commit('FETCH_AUTH',auth.data);
        },
        async login({commit},data){
            return await $api.post(`/api/login`,data);
        },
        async register({commit},data){
            return await $api.post(`/api/register`,data);
        },
        async updateUser({commit},user){
            await $api.post(RESOURCE_AUTH,user)
        },
        async changePassword({},password){
            return  await $api.post(RESOURCE_AUTH,password);
        },
        async logOut({commit}){
            window.localStorage.removeItem('tk');
        }
    }
}

export default userStore;
