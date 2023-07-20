<template>
    <div class="search-slide">
        <h1 class="text-left title">Search</h1>
        <div class="input-group mb-0 border">
            <input type="text" id="input-search" class="form-control border-0 focus-none" v-model="text_search" @input="searchUsers"
                   placeholder="Search...">
            <div class="input-group-append">
                <button class="pr-2 pl-2 input-group-text bg-base border-0" v-show="text_search.length > 0 && !isLoading" :disabled="text_search.length === 0"
                        @click="clearText">&times;</button>
                <div class="input-loading" v-show="isLoading">
                    <div class="icon-load spinner-border text-primary"></div>
                </div>
            </div>
        </div>
        <div class="result mt-4 pt-2 border-top">
            <User :user="user" :key="index" v-for="(user,index) in users"></User>
        </div>
    </div>
</template>

<script>
import User from "../User";
export default {
    components : {User},
    name: "SearchSlide",
    data(){
        return{
            users : null,
            isLoading : false,
            text_search : '',
            auth_data : window.Laravel,
        }
    },
    methods:{
        clearText(){
            this.text_search = '';
        },
        searchUsers() {
            if (this.text_search.length > 2) {
                this.isLoading = true;
                axios.get(`${this.auth_data.baseUrl}/api/user/s/${this.text_search}?api_token=${this.auth_data.api_token}`)
                    .then(response => {
                        this.users = response.data;
                        this.isLoading = false;
                    })
                    .catch(e => {
                        this.isLoading = false;
                    })
            }

        },
    }
}
</script>

<style scoped>
    .search-slide{
        position: absolute;
        top: 0;
        left: 100%;
        width: 400px;
        height: 100%;
        background: #f8fafc;
        transform: translateX(-180%);
        transition: .3s;
        padding : 0 10px;
        .title{
            padding: 20px 0;
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
        #input-search:focus{
            border-right: none;
        }

        .result{
            height: 82.5vh;
            overflow-y: auto;
        }
    }
    @media (max-width: 767px) {
        .search-slide{
            position: fixed;
            left: 0;
            width: 100%;
            transform: translateY(100%);
            .result{
                height: 75vh;
            }
        }
    }
</style>
