import chatRouter from "./chatRouter";
import profileRouter from "./profileRouter";
import postRouter from "./postRouter.";

const index = [
    {
        path : '/',
        component : () => import('../components/pages/HomePage'),
        name : 'home',
    },
    ...postRouter,
    ...chatRouter,
    ...profileRouter,
];
export default index;
