import chatRouter from "./chatRouter";
import profileRouter from "./profileRouter";
import postRouter from "./postRouter.";
import messageRouter from "./messageRouter";

const index = [
    {
        path : '/',
        component : () => import('../components/pages/HomePage'),
        name : 'home',
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
