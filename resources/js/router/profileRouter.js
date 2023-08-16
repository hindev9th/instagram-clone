const profileRouter = [
    {
        path : '/:username',
        component : () => import('../components/pages/ProfilePage'),
        name : 'profile',
    },
    {
        path : '/accounts/edit',
        component : () => import('../components/pages/Profiles/EditPage'),
        name : 'account',
    },
];

export default profileRouter;
