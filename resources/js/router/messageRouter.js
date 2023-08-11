const messageRouter = [
    {
        path: '/chat/message/:id',
        components: {
            default: () => import('../components/pages/ChatPage'),
            message: () => import('../components/pages/MessagePage'),
        },
        name: 'message'
    }
]

export default messageRouter;
