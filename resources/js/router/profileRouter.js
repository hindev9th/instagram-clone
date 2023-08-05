const profileRouter = [
    {
        path : '/:username',
        component : () => import('../components/pages/ProfilePage'),
        name : 'profile',
    }
];

export default profileRouter;
