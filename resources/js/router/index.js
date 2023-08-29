import chatRouter from "./chatRouter";
import profileRouter from "./profileRouter";
import postRouter from "./postRouter.";
import messageRouter from "./messageRouter";
import authRouter from "./authRouter";

const index = [
    ...authRouter,

    {
        path : '/',
        component : () => import('../components/pages/HomePage'),
        name : 'home',
        meta : {
            requiresAuth: true
        },
    },
    ...postRouter,
    ...chatRouter,
    ...profileRouter,
    ...messageRouter,
    {
        path : '*',
        component : () => import('../components/pages/Error/E404Page'),
        name : 'notfound',
    },
];
export default index;
