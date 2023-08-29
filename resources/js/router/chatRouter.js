
const chatRouter = [
    {
        path : '/chat',
        component : () => import('../components/pages/ChatPage'),
        name : 'chat',
        meta : {
            requiresAuth: true
        },
    }
];

export default chatRouter;
