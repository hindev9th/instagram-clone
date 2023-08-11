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
];
export default index;
