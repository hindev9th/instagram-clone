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
        async fetchProfileAndPosts({commit},username){
            let [profile , posts] =
            await Promise.all([
                $api.get(`${RESOURCE_PROFILES}/${username}`),
                $api.get(`${PROFILES_POSTS}/${username}`),
            ])
            commit('FETCH_PROFILE',profile.data);
            commit('FETCH_POSTS',posts.data);
        },
        async fetchProfile({commit},username){
            let profile = await $api.get(`${RESOURCE_PROFILES}/${username}`);
            commit('FETCH_PROFILE',profile.data);
        },
        async fetchPosts({commit}, username){
            let posts = await $api.get(`${PROFILES_POSTS}/${username}`)
            commit('FETCH_POSTS',posts.data);
        },
        async fetchMorePosts({commit}, {username, page}){
            let posts =  await $api.get(`${PROFILES_POSTS}/${username}?page=${page}`)
            commit('ADD_POSTS',posts.data);
        },
        async updateProfile({commit},profile){
            await $api.post(RESOURCE_PROFILES,profile)
        }
    }
};

export default profileStore;
