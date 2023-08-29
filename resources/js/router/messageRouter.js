const messageRouter = [
    {
        path: '/chat/message/:id',
        components: {
            default: () => import('../components/pages/ChatPage'),
            message: () => import('../components/pages/MessagePage'),
        },
        name: 'message',
        meta : {
            requiresAuth: true
        },
    }
]

export default messageRouter;
