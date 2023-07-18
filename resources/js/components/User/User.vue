<template>
    <div class="user d-flex mt-2 mb-3 align-items-center justify-content-between">
        <div class="info d-flex">
            <div class="avatar">
                <a class="mr-2" :href="`${base_url}/profile/${user.username}`"><img
                    :src="getImage(user.profile.image)" alt=""></a>
            </div>
            <div class="name d-flex flex-column">
                <a class="text-dark text-decoration-none"
                   :href="`${base_url}/profile/${user.username}`"><strong>{{ user.username }}</strong></a>
                <span class="text-black-50" style="font-size: 10px">{{ user.name }}</span>
            </div>
        </div>
        <follow-button :user-id="user.id"
                       :follows="user.isFollowing"
                       class="text-primary"></follow-button>
    </div>
</template>

<script>
import {getImage} from "../../functiton";
export default {
    name: "User",
    props: ['user'],
    data(){
        return{
            base_url : window.Laravel.baseUrl,
        }
    },
    methods:{
        getImage,
    }
}
</script>

<style scoped>

</style>
