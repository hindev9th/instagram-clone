<template>
    <div class="message-page">
        <ChatMessage class="open"></ChatMessage>
    </div>
</template>

<script>
import ChatMessage from "../Chat/ChatMessage";
import {mapGetters} from "vuex";
export default {
    components : {ChatMessage},
    name: "MessagePage",
    computed :{

    }
}
</script>

<style scoped>
</style>
