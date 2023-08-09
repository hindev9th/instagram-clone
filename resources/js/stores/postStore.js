import Vue from "vue";
import Vuex from "vuex";
import { RESOURCE_POSTS,POSTS_SUGGESTED,POSTS_OLD } from "../api/postApi";
import $api from "../api";

Vue.use(Vuex);

const postStore = {
    namespaced : true,
    state : {
        posts : null,
        postsOld : null,
        postsSug : null,
        post : null,
    },
    mutations : {
        FETCH_POSTS(state,posts){
            state.posts = posts;
        },
        FETCH_POSTS_OLD(state,posts){
            state.postsOld = posts;
        },
        FETCH_POSTS_SUG(state,posts){
            state.postsSug = posts;
        },
        FETCH_POST(state,post){
            state.post = post;
        },
        ADD_POSTS(state,posts){
            posts.data.forEach(e => state.posts.data.push(e));
        },
        ADD_POSTS_OLD(state,posts){
            posts.data.forEach(e => state.postsOld.data.push(e));
        },
        ADD_POSTS_SUG(state,posts){
            posts.data.forEach(e => state.postsSug.data.push(e));
        },
        ADD_NEW_POST(state,post){
            if (state.posts == null){
                state.posts = {
                    last_page : 1,
                    total : 1,
                    to: 1,
                    data : [
                        post,
                    ]
                }
            }else {
                state.posts.data.unshift(post);
            }
        },
        UPDATE_POST(state,post){
            if (state.posts != null){
                for (let index in state.posts.data){
                    if (state.posts.data[index].id === post.id){
                        state.posts.data.splice(index,1,post);
                        break;
                    }
                }
            }
            if (state.postsOld != null){
                for (let index in state.postsOld.data){

                    if (state.postsOld.data[index].id === post.id){
                        state.postsOld.data.splice(index,1,post);
                        return;
                    }
                }
            }
            if (state.post != null){
                state.post = post;
            }
        },
        DELETE_POST(state,id){
            if (state.posts != null){
                for (let index in state.posts.data){
                    if (state.posts.data[index].id === id){
                        state.posts.data.splice(index,1);
                        break;
                    }
                }
            }
            if (state.postsOld != null){
                for (let index in state.postsOld.data){

                    if (state.postsOld.data[index].id === id){
                        state.postsOld.data.splice(index,1);
                        return;
                    }
                }
            }
            if (state.postsSug != null){
                for (let index in state.postsSug.data){
                    if (state.postsSug.data[index].id === id){
                        state.postsSug.data.splice(index,1);
                        break;
                    }
                }
            }
            if (state.post != null){
                this.$router.push({name : 'home'});
            }
        }
    },
    getters :{
        getPosts(state){
            return state.posts;
        },
        getPostsOld(state){
            return state.postsOld;
        },
        getPostsSug(state){
            return state.postsSug;
        },
        getPost(state){
            return state.post;
        }
    },
    actions : {
        async fetchPosts({commit},page){
            await $api.get(`${RESOURCE_POSTS}?page=${page}`)
                .then(res => {
                    if (page === 1){
                        commit('FETCH_POSTS',res.data);
                    }else {
                        commit('ADD_POSTS',res.data);
                    }
                })
        },
        async fetchPostOld({commit},page){
            await $api.get(`${POSTS_OLD}?page=${page}`)
                .then(res =>{
                    if (page === 1){
                        commit('FETCH_POSTS_OLD',res.data);
                    }else {
                        commit('ADD_POSTS_OLD',res.data);
                    }
                })
        },
        async fetchPostSug({commit},page){
            await $api.get(`${POSTS_SUGGESTED}?page=${page}`)
                .then(res =>{
                    if (page === 1){
                        commit('FETCH_POSTS_SUG',res.data);
                    }else {
                        commit('ADD_POSTS_SUG',res.data);
                    }
                })
        },
        async fetchPost({commit},id){
            await $api.get(`${RESOURCE_POSTS}/${id}`)
                .then(res =>{
                    commit('FETCH_POST',res.data);
                })
        },
        async addPost({commit},post){
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }
            let response = await $api.post(`${RESOURCE_POSTS}`,post,config);
            commit('ADD_NEW_POST',response.data);
        },
        async updatePost({commit}, {id, post}){
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }

            await $api.post(`${RESOURCE_POSTS}/${id}`,post,config)
                .then(res => {
                    commit('UPDATE_POST', res.data);
                })
        },
        async deletePost({commit},id){
            await $api.post(`${RESOURCE_POSTS}/${id}`,{
                _method : 'DELETE',
            });
            commit('DELETE_POST',id);
        }


    }
}

export default postStore;
