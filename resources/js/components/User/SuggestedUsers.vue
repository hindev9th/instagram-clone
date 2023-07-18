<template>
    <div class="suggested-users">
        <User :user="user" v-for="(user,index) in users" :key="index"></User>
    </div>
</template>

<script>
import User from "./User";
export default {
    components:{User},
    name: "SuggestedUsers",
    data(){
        return{
            users : null,
            api_token: window.Laravel.api_token,
            base_url : window.Laravel.baseUrl,
            page: 0,
        }
    },
    mounted() {
        this.fetchSugUserS();
    },
    methods:{
        fetchSugUserS() {
            this.page++;
            axios.get(`${this.base_url}/api/user?api_token=${this.api_token}&page=${this.page}`)
                .then(res => {
                    this.users = res.data.data;
                })
                .catch(e => {

                })
        }
    }
}
</script>

<style scoped>

</style>
