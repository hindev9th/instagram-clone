<template>
    <div class="comment d-flex mt-2 mb-2">
        <div class="pr-1">
            <img :src="getImage(comment.user.profile.image)"
                 class="avatar rounded-circle" alt="">
        </div>
        <div class="pl-2">
            <a :href="base_url + '/profile/' + comment.user.username"
               class="text-decoration-none text-dark"><strong>{{comment.user.username}}</strong></a>
            {{ comment.comment }}
            <div class="time">
                {{ formatTime(comment.created_at) }}
            </div>
        </div>
    </div>
</template>

<script>
import {getImage,formatTime} from "../../../functiton";
export default {
    name: "comment",
    props: ['comment','user'],
    created() {
    },
    data(){
        return{
            base_url:window.Laravel.baseUrl,
        }
    },
    methods:{
        getImage,formatTime,
    }
}
</script>

<style scoped>

</style>
