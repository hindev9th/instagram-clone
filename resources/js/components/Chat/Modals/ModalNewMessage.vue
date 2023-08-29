<template>
    <div class="modal fade" id="modal-new" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content overflow-hidden border-0">
                <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                    <strong>New message</strong>
                    <button type="button" @click="clearModal" class="close position-absolute p-0" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">
                    <ul class="list-unstyled m-0">
                        <li class="p-2 border-bottom d-flex align-items-start flex-wrap">
                            <div id="tag-users" class="d-flex flex-wrap">
                                <div class="user d-flex m-1" @dblclick="deleteTagUser(index)"
                                     v-for="(user,index) in selected">
                                    <span class="name text-dark font-weight-bold">{{ user.username }}</span>
                                    <span class="tag-delete text-hover-dark-20"
                                          @click="deleteTagUser(index)">&times</span>
                                </div>
                            </div>
                            <div class="input-group mb-0 bg-white">
                                <input type="text" id="search-new-message" class="form-control p-0 m-0 pl-2 border-0 focus-none" v-model="search" @input="searchUsers"
                                       placeholder="Search...">
                                <div class="input-group-append">
                                    <button class="pr-2 pl-2 input-group-text bg-white border-0" v-show="search.length > 0 && !isSearching" :disabled="search.length === 0"
                                            @click="clearText">&times;</button>
                                    <div class="input-loading" v-show="isSearching">
                                        <div class="icon-load spinner-border text-primary"></div>
                                    </div>
                                </div>
                            </div>

                        </li>
                        <li class="">
                            <div class="w-100 overflow-auto border-0 focus-none" multiple
                                 style="height: 500px;">
                                <div class="pl-2" v-if="users.length < 1">No account found.</div>
                                <div :key="user.id" :value="user.username" @click="addTagUser(user)"
                                     class="select-user hover-dark-20 d-flex p-2" v-for="user in users">
                                    <img :src="getImage(user.profile.image)" width="35px" height="35px"
                                         class="avatar border rounded-circle mr-2" alt="">
                                    <div class="name d-flex flex-column">
                                        <strong>{{ user.name }}</strong>
                                        <span>{{ user.username }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="p-2 border-bottom d-flex align-items-center">
                            <button id="btn-new-chat" :disabled="selected_id.length === 0 || isLoading" @click="createChatRoom"
                                    class="btn btn-primary w-100">
                                <span class="spinner-border mr-1 spinner-border-sm" v-if="isLoading" role="status" aria-hidden="true"></span>
                                {{ isLoading ?'Creating...' : 'Chat'}}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getImage} from "../../../functiton";
import {showNotify} from "../../../functiton";
import $api from "../../../api/apiClient";
import {USER_SEARCH} from "../../../api/userApi";
import {mapActions} from "vuex";
export default {
    name: "ModalNewMessage",
    data() {
        return {
            selected: [],
            selected_id: [],
            search: '',
            isSearching : false,
            isLoading: false,
            users: [],
            auth_data : window.Laravel,
            timer : undefined
        }
    },
    methods: {
        showNotify,getImage,
        ...mapActions('chat',['addNewChatHandle','getChatId']),

        clearModal() {
            this.selected = []
            this.selected_id = []
            this.users = [];
            this.search = '';
        },
        closeModal(){
            this.selected = []
            this.selected_id = []
            this.users = [];
            this.search = '';
            this.isLoading = false;
            $('#modal-new').modal('hide');
        },
        searchUsers() {
            clearTimeout(this.timer);
            this.timer = setTimeout(async () => {
                if (!this.search) {
                    this.clearText();
                } else {
                    this.isSearching = true;
                    await $api.get(`${USER_SEARCH}/${this.search}`)
                        .then(response => {
                            this.users = response.data;
                            this.isSearching = false;
                        })
                        .catch(e => {
                            this.isSearching = false;
                        })
                }

            }, 1000)
        },
        createChatRoom() {
            this.isLoading = true;
            this.getChatId(this.selected_id).then(id => {
                if (id) {
                    this.$router.push({name: 'message', params: {id: id}}).catch(() => {
                    });
                    this.closeModal();
                } else {
                    this.addNewChatHandle(this.selected_id)
                        .then(() => {
                            this.closeModal();
                            showNotify('Create chat room success.');
                        }).catch(e => {
                        this.isLoading = false;
                        console.log(e)
                        showNotify('Error! Cannot create chat room.');
                    })
                }
            })

        },
        addTagUser(user) {
            if (!this.selected.find(e => e.id === user.id)) {
                this.selected.push(user);
                this.selected_id.push(user.id);
            }

            this.users = [];
            this.search = '';
        },
        deleteTagUser(index) {
            this.$delete(this.selected, index)
            this.$delete(this.selected_id, index)
        },
        clearText(){
            this.search = '';
            this.users = [];
        }
    },
}
</script>

<style>
.modal-header {

.close {
    top: 24%;
    right: 16px;
    font-size: 30px;
}

}
#search-new-message {
    width: auto;
    min-width: 200px;
}

#tag-users {

.user {
    cursor: pointer;
    background: #00b9ef;
    border-radius: 12px;
    padding: 5px 20px 5px 10px;
    position: relative;
    -webkit-user-select: none; /* Safari */
    -ms-user-select: none; /* IE 10 and IE 11 */
    user-select: none;

/* Standard syntax */

.tag-delete {
    cursor: pointer;
    position: absolute;
    right: 5px;
    color: #000;
}

}

}

.input-group{
    border-radius: 12px;
    overflow: hidden;
.input-loading{
    display : flex;
    align-items: center;
    justify-content: center;
    padding: 0 5px;

.icon-load{
    width: 1rem;
    height: 1rem;
}
}
}
</style>
