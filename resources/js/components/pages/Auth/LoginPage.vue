<template>
    <div class="container">
        <div class="box-login">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form action="" @submit.prevent="handleLogin">
                            <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input type="email" id="email" v-model="email" class="form-control" required placeholder="Your email..">
                                    </div>
                            </div>
                            <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" v-model="password" class="form-control" required placeholder="Your password..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" :disabled="isLoading">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <span>You don't have account.<RouterLink :to="{name : 'register'}">Register</RouterLink></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {showNotify} from "../../../functiton";

export default {
    name: "LoginPage",
    data(){
        return{
            email : null,
            password : null,
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
        ...mapGetters('auth',['getAuth']),
        ...mapActions('auth',['login','fetchAuth']),
        handleLogin(){
            let data = new FormData();
            data.set('email',this.email);
            data.set('password',this.password);
            this.isLoading = true;
            this.login(data).then(res => {
                if (res.data.status === 200){
                    this.isLoading = false;
                    window.localStorage.setItem('tk',res.data.token);
                    this.fetchAuth().then(res => {
                        this.$router.push({name : 'home'});
                    });
                }
                if (res.data.status === 401){
                    this.isLoading = false;
                    showNotify("Invalid email or password information. Please try again later")
                }
            })
        }
    }
}
</script>

<style scoped>
</style>
