import Vuex from 'vuex';
import userStore from "./userStore";
import postStore from "./postStore";
import chatStore from "./chatStore";
import profileStore from "./profileStore";
import commentStore from "./commentStore";
import messageStore from "./messageStore";
import authStore from "./authStore";

const index = new Vuex.Store({
    modules: {
        user : userStore,
        post : postStore,
        chat : chatStore,
        profile : profileStore,
        comment : commentStore,
        message : messageStore,
        auth : authStore,
    }
});

export default index;
