<template>
    <div id="new-message">
        <span class="btn-setting text-hover-dark-20" @click="showModal" data-toggle="modal" data-backdrop="static" data-keyboard="false"
              data-target="#modal-new" style="font-size: 18px"><i class="far fa-edit"></i></span>

        <div class="modal fade" v-if="" id="modal-new" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content overflow-hidden border-0">
                    <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                        <strong>New message</strong>
                        <button type="button" @click="showModal" class="close position-absolute" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-0">
                        <ul class="list-unstyled m-0">
                            <li class="p-2 border-bottom d-flex align-items-start flex-wrap">
                                <div id="tag-users" class="d-flex flex-wrap">
                                    <div class="user d-flex m-1" @dblclick="deleteTagUser(index)" v-for="(user,index) in selected">
                                        <span class="name text-dark font-weight-bold">{{ user.username }}</span>
                                        <span class="tag-delete text-hover-dark-20" @click="deleteTagUser(index)">&times</span>
                                    </div>
                                </div>
                                <input type="text" v-model="search" @input="searchUsers"
                                       class="form-control p-0 m-0 pl-2 border-0 focus-none" id="search-new-message"
                                       placeholder="Search..."/>

                            </li>
                            <li>
                            </li>
                            <li class="">
                                <div class="w-100 overflow-auto border-0 focus-none" multiple
                                     style="height: 500px;">
                                    <div class="pl-2" v-if="users.length < 1">No account found.</div>
                                    <div :key="user.id" :value="user.username" @click="addTagUser(user)"
                                         class="select-user hover-dark-20 d-flex p-2" v-for="user in users">
                                        <img :src="getImage(user.profile.image)" width="35px" height="35px" class="avatar border rounded-circle mr-2" alt="">
                                        <div class="name d-flex flex-column">
                                            <strong>{{ user.name }}</strong>
                                            <span>{{ user.username }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="p-2 border-bottom d-flex align-items-center">
                                <button id="btn-new-chat" :disabled="selected_id.length === 0" @click="createChatRoom" class="btn btn-primary w-100">Chat</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'jquery';
import {getImage} from "../../functiton";
export default {
    name: "NewButton",
    data() {
        return {
            isShow: false,
            selected: [],
            selected_id: [],
            search: '',
            users: [],
        }
    },
    methods: {
        getImage,
        showModal() {
            this.isShow = !this.isShow;
            this.selected = []
            this.selected_id = []
            this.users = [];
            this.search = '';
        },
        searchUsers() {
            if (this.search.length > 2) {
                axios.get(window.Laravel.baseUrl + '/api/user/s/' + this.search)
                    .then(response => {
                        this.users = response.data;
                    })
            }

        },
        createChatRoom() {
            axios.post(window.Laravel.baseUrl + '/c', {
                users: this.selected_id
            }).then(response => {
                $('#modal-new').modal('hide');
                this.selected = []
                this.selected_id = []
                this.users = [];
                this.search = '';
            })
        },
        addTagUser(user){
            if (!this.selected.find(e => e.id === user.id)){
                this.selected.push(user);
                this.selected_id.push(user.id);
            }

            this.users = [];
            this.search = '';
        },
        deleteTagUser(index){
            this.$delete(this.selected, index)
            this.$delete(this.selected_id, index)
        }
    }
}
</script>

<style>
.modal-header {

.close {
    top: 10px;
    right: 16px;
    font-size: 30px;
}

}
#search-new-message{
    width: auto;
    min-width: 200px;
}
#tag-users{
    .user{
        cursor: pointer;
        background: #00b9ef;
        border-radius: 12px;
        padding: 5px 20px 5px 10px;
        position: relative;
        -webkit-user-select: none; /* Safari */
        -ms-user-select: none; /* IE 10 and IE 11 */
        user-select: none; /* Standard syntax */

        .tag-delete{
            cursor: pointer;
            position: absolute;
            right: 5px;
            color: #000;
        }
    }

}
</style>
