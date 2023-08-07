<template>
    <div class="box-main">
        <div class="post-home container">
            <div class="box-post d-flex justify-content-around w-100">
                <PostsList></PostsList>
                <RememberUser></RememberUser>
            </div>
        </div>
    </div>
</template>

<script>
import SuggestedUsers from "../User/SuggestedUsers";
import ShowUserButton from "../User/Buttons/ShowUserButton";
import PostsList from "../Posts/PostsList";
import RememberUser from "../User/RememberUser";
export default {
    components : {SuggestedUsers,ShowUserButton,PostsList,RememberUser},
    name: "HomePage",

}
</script>

<style scoped>

</style>
