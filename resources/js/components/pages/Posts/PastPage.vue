<template>
    <div class="box-main">
        <div class="post-home container">
            <div class="box-post d-flex justify-content-around w-100">
                <div class="col-md-8 d-flex flex-column align-items-center posts" id="posts" v-if="getPostsOld">
                    <div class="post-old" >
                        <div class="pt-2 pb-2" v-for="(post,index) in getPostsOld.data"  >
                            <Post :post="post" :key="index"></Post>
                            <RememberUser class="small" v-if="index === isShowSugUsers"></RememberUser>
                        </div>
                        <infinite-loading @infinite="infiniteLoad"></infinite-loading>
                    </div>
                </div>
                <RememberUser></RememberUser>
            </div>
        </div>
    </div>
</template>

<script>
import RememberUser from "../../User/RememberUser";
import Post from "../../Posts/Post";
import {mapGetters,mapActions} from 'vuex';
export default {
    components : {Post,RememberUser},
    name: "PastPage",
    data(){
        return{
            page: 1,
            isShowSugUsers : 0,
        }
    },
    created() {
      this.fetchPostOld(this.page).then(e => {
          this.isShowSugUsers = Math.floor(Math.random() * this.getPostsOld.total);
      });
    },
    computed:{
        ...mapGetters('post',['getPostsOld']),
    },
    methods:{
        ...mapActions('post',['fetchPostOld']),
        infiniteLoad($state){
            setTimeout(()=>{
                this.page++;
                this.fetchPostOld(this.page).then(e => {
                    if (this.getPostsOld.last_page <= this.page){
                        $state.complete();
                    }else {
                        $state.loaded();
                    }
                })
            },1000)

        },
    }
}
</script>

<style scoped>

</style>
