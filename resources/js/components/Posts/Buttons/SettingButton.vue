<template>
    <div class="setting">
        <span class="btn-setting" @click="showModal"> <i class="fas fa-ellipsis-h"></i></span>

        <transition name="fade" mode="out-in">
            <ModalSetting @close-modal="showModal" v-if="isShow"></ModalSetting>
        </transition>
    </div>
</template>

<script>
    import ModalSetting from "../Modals/ModalSetting.vue";
export default {
    components: {ModalSetting},
    name: "SettingButton",
    data(){
        return{
            isShow : false,
        }
    },
    methods: {
        showModal() {
            this.isShow = !this.isShow
        },
    },
}
</script>

<style scoped>
    .setting{
        position: absolute;
        right: 20px;
        display: flex;
        align-items: center;
        height: 100%;
    }
    .btn-setting{
        cursor: pointer;
    }
</style>
