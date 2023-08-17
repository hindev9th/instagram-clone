import Vue from "vue";
import Vuex from "vuex";
import {RESOURCE_COMMENTS} from "../api/commentApi";
import $api from "../api";

Vue.use(Vuex);

const commentStore = {
    namespaced : true,
    state :{
        comments : null,
        comment: null,
    },
    mutations : {
        FETCH_COMMENTS(state,comments){
            state.comments = comments;
        },
        FETCH_COMMENT(state, comment){
            state.comment = comment;
        },
        ADD_COMMENTS(state,comments){
            comments.data.forEach(e => state.comments.data.push(e));
        },
        ADD_COMMENT(state,comment){
            state.comments.data.push(comment);
        },
        UPDATE_COMMENT(state, comment) {
            for (let index in state.comments.data) {
                if (state.comments.data[index].id === comment.id) {
                    state.comments.data.splice(index, 1, comment);
                    break;
                }
            }
        },
        DELETE_COMMENT(state, id) {
            for (let index in state.comments.data) {
                if (state.comments.data[index].id === id) {
                    state.comments.data.splice(index, 1);
                    break;
                }
            }
        }
    },
    getters :{
        getComments(state){
            return state.comments;
        },
    },
    actions :{
        async fetchComments({commit}, {postId,page}){
            let comments = await $api.get(`${RESOURCE_COMMENTS}/${postId}?page=${page}`);
            if (page === 1) commit('FETCH_COMMENTS',comments.data);
            if (page > 1) commit('ADD_COMMENTS',comments.data);
        },
        async addComment({commit}, formData){
            let comment =  await $api.post(`${RESOURCE_COMMENTS}`,formData);
            if (!comment.data.parent_id){
                commit('ADD_COMMENT',comment.data);
            }
            return comment;
        },
        async updateComment({commit}, comment) {
            let response = await $api.post(`${RESOURCE_COMMENTS}/${comment.id}`,
                {
                    _method: 'PATCH',
                    comment: comment.comment,
                })
            commit('UPDATE_COMMENT', comment);
        },
        async deleteComment({commit}, id){
            await $api.post(`${RESOURCE_COMMENTS}/${id}`,
                {
                    _method: 'DELETE',
                })
                .then(res => {
                    commit('DELETE_COMMENT',id);
                })
        },

    }
};

export default commentStore;
