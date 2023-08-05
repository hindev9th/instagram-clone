import Vuex from 'vuex';
import userStore from "./userStore";
import postStore from "./postStore";
import chatStore from "./chatStore";
import profileStore from "./profileStore";

const index = new Vuex.Store({
    modules: {
        user : userStore,
        post : postStore,
        chat : chatStore,
        profile : profileStore,
    }
});

export default index;
