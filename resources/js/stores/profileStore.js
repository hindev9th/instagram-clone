import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_PROFILES,PROFILES_EDIT,PROFILES_POSTS} from '../api/profileApi';
import $api from "../api";

Vue.use(Vuex);

const profileStore = {
    namespaced : true,
    state :{
        profile : {},
        posts: null,
    },
    mutations : {
        FETCH_PROFILE(state,profile){
            state.profile = profile;
        },
        FETCH_POSTS(state, posts){
            state.posts = posts;
        },
        ADD_POSTS(state,posts){
            posts.data.forEach(e => state.posts.data.push(e));
        }
    },
    getters :{
        getProfile(state){
            return state.profile;
        },
        getPosts(state){
            return state.posts;
        }
    },
    actions :{
        async fetchProfile({commit},username){
            await $api.get(`${RESOURCE_PROFILES}/${username}`)
                .then(res =>{
                    commit('FETCH_PROFILE',res.data);
                })
        },
        async fetchPosts({commit}, username){
            await $api.get(`${PROFILES_POSTS}/${username}`)
                .then(res =>{
                    commit('FETCH_POSTS',res.data);
                })
        },
        async fetchMorePosts({commit}, {username, page}){
            await $api.get(`${PROFILES_POSTS}/${username}?page=${page}`)
                .then(res =>{
                    commit('ADD_POSTS',res.data);
                })
        },
    }
};

export default profileStore;
