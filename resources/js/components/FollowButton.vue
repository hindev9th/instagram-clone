<template>
    <div>
        <button class="btn btn-primary" @click="followUser" v-text="buttonText" style="height: fit-content"></button>
    </div>
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
                    this.status = response.data.attached.length > 0;
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
