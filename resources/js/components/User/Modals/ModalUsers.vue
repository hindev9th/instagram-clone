<template>
    <div class="modal fade" id="modal-users" tabindex="-1"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content overflow-hidden border-0">
                <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                    <strong>{{ title }}</strong>
                    <button type="button" @click="$emit('close-modal')" class="close position-absolute" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box-users">
                        <User :user="user" :key="index" v-for="(user,index) in users"></User>
                        <div class="w-100 text-center">
                            <span class="p-3 text-primary prevent-select cursor-pointer" v-if="isShowMore" @click="fetchUsers">Show more</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import User from "../User";
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
        fetchUsers(){
            this.page++;
            axios.get(`${this.action}?api_token=${this.api_token}&page=${this.page}`)
            .then(res => {
                if (this.users == null){
                    this.users = res.data.data;
                }else {
                    res.data.data.forEach(e => this.users.push(e));
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
        height: 600px;
        max-height: 600px;
        overflow-y: auto;
    }
</style>
