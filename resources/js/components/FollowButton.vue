<template>
    <span class="pr-2 focus-none cursor-pointer prevent-select" @click="followUser" v-text="buttonText" style="height: fit-content"></span>
</template>
<script>
    export default {
        props: ['userId','follows'],

        mounted(){
            console.log('vue js');
        },

        data : function (){
            return {
                status : this.follows
            }
        },
        methods: {
            followUser() {
                axios.post('/follow/'+this.userId).then(response => {
                    this.status = !this.status;
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
