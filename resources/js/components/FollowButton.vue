<template>
    <span class="pr-2 focus-none cursor-pointer prevent-select" @click="followUser" v-text="buttonText" style="height: fit-content"></span>
</template>
<script>
    export default {
        props: ['userId','follows'],

        mounted(){

        },

        data : function (){
            return {
                status : this.follows,
                auth_data : window.Laravel,
            }
        },
        methods: {
            followUser() {
                axios.post(`${this.auth_data.baseUrl}/api/follow/${this.userId}?api_token=${this.auth_data.api_token}`,{
                    _token : this.auth_data.csrf_token,
                }).then(response => {
                    this.status = !this.status;
                    this.$emit('follow',this.status);
                })
                .catch(errors => {
                    if (errors.response.status === 401){
                        window.location = '/login';
                    }
                });
            }
        },
        computed : {
            buttonText(){
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>
