
const postRouter = [
    {
        path : '/past',
        component : () => import('../components/pages/Posts/PastPage'),
        name : 'past'
    },
    {
        path : '/p/:id',
        component : () => import('../components/pages/PostShowPage'),
        name: 'post'
    }
];

export default postRouter;
