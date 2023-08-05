<template>
    <div class="suggested-users">
        <User :user="user" v-for="(user,index) in suggested.data" :key="index"></User>
    </div>
</template>

<script>
import User from "./User";
import {mapActions,mapState} from 'vuex';
export default {
    components:{User},
    name: "SuggestedUsers",
    created() {
        this.$store.dispatch('user/fetchSuggested');
    },
    methods:{

    },
    computed:{
        ...mapActions('user',['fetchSuggested']),
        ...mapState('user',['suggested'])

    }
}
</script>

<style scoped>

</style>
