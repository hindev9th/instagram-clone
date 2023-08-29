
const postRouter = [
    {
        path : '/past',
        component : () => import('../components/pages/Posts/PastPage'),
        name : 'past',
        meta : {
            requiresAuth: true
        },
    },
    {
        path : '/p/:id',
        component : () => import('../components/pages/PostShowPage'),
        name: 'post',
        meta : {
            requiresAuth: true
        },
    }
];

export default postRouter;
