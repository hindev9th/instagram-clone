<template>
    <div>
        <span class="font-weight-bold cursor-pointer prevent-select" @click="hideAndShowModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal-users" v-text="text"></span>
        <ModalUsers v-if="isShow" @close-modal="hideAndShowModal" :title="title" :action="action"></ModalUsers>
    </div>
</template>

<script>
import ModalUsers from "../Modals/ModalUsers";
export default {
    components: {ModalUsers},
    name: "ShowUserButton",
    props: ['text','title','action'],
    data(){
        return{
            isShow: false,
        }
    },
    methods:{
        hideAndShowModal(){
            this.isShow = !this.isShow;
        }
    }
}
</script>

<style scoped>

</style>
