<template>
    <span class="focus-none cursor-pointer prevent-select" @click="followUser" v-text="buttonText" style="height: fit-content"></span>
</template>
<script>
    import $api from "../api";
    import {RESOURCE_FOLLOWS} from "../api/followApi";

    export default {
        props: ['username','follows'],
        data : function (){
            return {
                status : this.follows,
                auth_data : window.Laravel,
            }
        },
        methods: {
            async followUser() {
                await $api.post(`${RESOURCE_FOLLOWS}/${this.username}`)
                    .then(res => {
                        this.status = !this.status;
                        this.$emit('follow', this.status);
                    })
                    .catch(errors => {
                        if (errors.response.status === 401) {
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
