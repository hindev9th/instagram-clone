<template>
    <div class="container">
        <div class="box-login">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Register
                    </div>
                    <div class="card-body">
                        <form action="" @submit.prevent="handleRegister">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" v-model="name" class="form-control" required placeholder="Your name..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input type="text" id="username" v-model="username" class="form-control" required placeholder="Your username..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="email" id="email" v-model="email" class="form-control" required placeholder="Email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" v-model="password" class="form-control" required placeholder="Password..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Password confirm</label>
                                <div class="col-md-6">
                                    <input type="password" id="password_confirmation" v-model="password_confirmation" class="form-control" required placeholder="Password..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" :disabled="isLoading">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <span>You already have an account.<RouterLink :to="{name : 'login'}">Login</RouterLink></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import {showNotify} from "../../../functiton";

export default {
    name: "RegisterPage",
    data(){
        return{
            name : null,
            username : null,
            email : null,
            password : null,
            password_confirmation : null,
            isLoading : false,
        }
    },
    created() {
        if (window.localStorage.getItem('tk'))  {
            this.fetchAuth().then(res => {
                this.$router.push({name : 'home'});
            });
        }
    },
    methods :{
        ...mapActions('auth',['register','fetchAuth']),
        handleRegister(){
            let data = new FormData();
            data.set('name',this.name);
            data.set('username',this.username);
            data.set('email',this.email);
            data.set('password',this.password);
            data.set('password_confirmation',this.password_confirmation);
            this.isLoading = true;
            this.register(data).then(res => {
                this.isLoading = false;
                window.localStorage.setItem('tk',res.data.token);
                this.fetchAuth().then(res => {
                    this.$router.push({name : 'home'});

                });
            }).catch(e => {
                this.isLoading = false;
                if (e.response.data.errors.name){
                    showNotify('Your name : '+ e.response.data.errors.name[0]);
                }
                if (e.response.data.errors.username){
                    showNotify('Your username : '+e.response.data.errors.username[0]);
                }
                if (e.response.data.errors.email){
                    showNotify('Your email : '+e.response.data.errors.email[0]);
                }
                if (e.response.data.errors.password){
                    showNotify('Your password : '+e.response.data.errors.password[0]);
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
