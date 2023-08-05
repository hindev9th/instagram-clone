<template>
    <div class="modal fade" id="modal-users" tabindex="-1"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content overflow-hidden border-0">
                <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                    <strong>{{ title }}</strong>
                    <button type="button" @click="$emit('close-modal')" class="close position-absolute p-0" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box-users">
                        <User :user="user" :key="index" v-for="(user,index) in users"></User>
                        <div class="w-100 text-center">
                            <span class="p-3 text-primary prevent-select cursor-pointer" v-if="isShowMore" @click="fetchUsers">Show more</span>
                            <infinite-loading @infinite="fetchUsers"></infinite-loading>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import User from "../User";
import $api from "../../../api";
export default {
    components: {User},
    name: "ModalUsers",
    props: ['action','title'],
    data(){
        return  {
            users: null,
            page : 0,
            api_token: window.Laravel.api_token,
            isShowMore: false,
        }
    },
    mounted() {
        this.fetchUsers();
    },
    methods:{
        async fetchUsers($state){
            this.page++;
            await $api.get(`${this.action}?page=${this.page}`).then(res => {
                if (this.users == null){
                    this.users = res.data.data;
                }else {
                    res.data.data.forEach(e => this.users.push(e));
                }
                if (this.page >= res.data.last_page){
                    $state.complete();
                }else {
                    $state.loaded();
                }
                this.isShowMore = this.users.length < res.data.total;
            })
            .catch(e =>{

            })
        }
    }
}
</script>

<style scoped>
    .box-users{
        height: 500px;
        max-height: 500px;
        overflow-y: auto;
    }
</style>
