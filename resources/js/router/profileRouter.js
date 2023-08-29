const profileRouter = [
    {
        path : '/:username',
        component : () => import('../components/pages/ProfilePage'),
        name : 'profile',
        meta : {
            requiresAuth: true
        },
    },
    {
        path : '/accounts/edit',
        component : () => import('../components/pages/Profiles/EditPage'),
        name : 'account',
        meta : {
            requiresAuth: true
        },
    },
];

export default profileRouter;
