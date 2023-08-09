import Vuex from 'vuex';
import userStore from "./userStore";
import postStore from "./postStore";
import chatStore from "./chatStore";
import profileStore from "./profileStore";
import commentStore from "./commentStore";

const index = new Vuex.Store({
    modules: {
        user : userStore,
        post : postStore,
        chat : chatStore,
        profile : profileStore,
        comment : commentStore,
    }
});

export default index;
