
const chatRouter = [
    {
        path : '/chat',
        component : () => import('../components/pages/ChatPage'),
        name : 'chat',
    }
];

export default chatRouter;
