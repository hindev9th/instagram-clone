const authRouter = [
    {
        path : '/login',
        component : ()=> import('../components/pages/Auth/LoginPage'),
        name : 'login'
    },
    {
        path : '/register',
        component : ()=> import('../components/pages/Auth/RegisterPage'),
        name : 'register'
    }
]

export default authRouter;
