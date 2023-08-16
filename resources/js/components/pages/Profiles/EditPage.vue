<template>
    <div class="box-main">
        <div class="container">
            <h1 class="text-center pb-5">Accounts Center</h1>
            <h4>Profile</h4>
            <div class="Profile w-100 pb-5" v-if="auth.profile">

                <form @submit.prevent="updateProfileHandle">
                    <div class="text-center pb-3">
                        <label for="image-avt" class="rounded-circle" :style="{background: `url(${imagePreview ? imagePreview : getImage(auth.profile.image)}) 0% 0% / 100% 100%`, width: '200px' , height : '200px'}"></label>
                        <input type="file" accept='image/*' @change="onFileChange" id="image-avt" class="d-none">
                    </div>
                    <div class="pb-3">
                        <label for="title" >Title</label>
                        <input type="text" id="title" class="form-control" v-model="auth.profile.title"/>
                    </div>
                    <div class="pb-3">
                        <label for="description" >Description</label>
                        <input type="text" id="description" class="form-control" v-model="auth.profile.description"/>
                    </div>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
            <h4>Personal details</h4>
            <div class="personal-details pb-3" v-if="auth">
                <form @submit.prevent="updateAccount">
                    <div class="pb-3">
                        <label for="name" >Name</label>
                        <input type="text" id="name" class="form-control" v-model="auth.name"/>
                    </div>
                    <div class="pb-3">
                        <label for="username" >Username</label>
                        <input type="text" id="username" class="form-control" v-model="auth.username"/>
                    </div>
                    <div class="cursor-pointer prevent-select p-2 mb-3 border hover-dark-20 rounded-lg d-flex justify-content-between align-items-center"  @click="!auth.email_verified_at && verify()">
                        <span>Identity confirmation</span>
                        <svg xmlns="http://www.w3.org/2000/svg" v-if="!auth.email_verified_at" height="1em" viewBox="0 0 320 512"><path d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" style="fill: green" v-if="auth.email_verified_at" height="1em" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                    </div>

                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
            <h4>Password</h4>
            <div class="password">
                <form action="" @submit.prevent="changePasswordHandle">
                    <div class="pb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" v-model="password">
                    </div>
                    <div class="pb-3">
                        <label for="new_password">New password</label>
                        <input type="password" class="form-control" id="new_password" v-model="new_password">
                    </div>
                    <div class="pb-3">
                        <label for="new_password_confirmation">Password confirmation</label>
                        <input type="password" class="form-control" id="new_password_confirmation" v-model="new_password_confirmation">
                    </div>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {getImage, showNotify} from "../../../functiton";

export default {
    name: "EditPage",
    data(){
        return{
            imagePreview : null,
            file : null,
            password : null,
            new_password : null,
            new_password_confirmation : null,
        }
    },
    computed:{
        ...mapGetters('user',{
            auth : 'getAuth',
        })
    },
    methods:{
        getImage,
        ...mapActions('user',['updateUser','changePassword']),
        ...mapActions('profile',['updateProfile']),
        onFileChange(e) {
            const file = e.target.files[0];
            this.imagePreview = URL.createObjectURL(file);

            this.file = file;
        },
        verify(){
            location.href = window.Laravel.baseUrl + '/email/verify';
        },
        updateAccount(){
            let user = new FormData();
            user.set('_method','PATCH');
            user.set('name',this.auth.name);
            user.set('username',this.auth.username);

            this.updateUser(user).then(()=>{
                showNotify('Update Personal details success!');
            }).catch(error => {
                if (error.response.status === 422) {
                    showNotify(error.response.data.errors.username[0]);
                }
                console.log(error)
            })
        },
        updateProfileHandle(){
            let profile = new FormData();
            profile.set('_method','PATCH');
            profile.set('title',this.auth.profile.title);
            profile.set('description',this.auth.profile.description);
            if (this.file){
                profile.set('image',this.file);
            }

            this.updateProfile(profile)
                .then(() => {
                    showNotify('Update profile success!');
                })
                .catch(error => {
                    console.log(error)
                })
        },
        changePasswordHandle(){
            let data = new FormData();
            data.set('_method','PUT');
            data.set('password',this.password);
            data.set('new_password',this.new_password);
            data.set('new_password_confirmation',this.new_password_confirmation);
            this.changePassword(data).then(res =>{
                console.log(res)

                showNotify(res.data.status);
            }).catch(error => {
                if (error.response.status === 422) {
                    showNotify(error.response.data.errors.new_password[0]);
                }
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
