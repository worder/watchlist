import { configureStore } from '@reduxjs/toolkit';

import userApi from '../api/user/userApi';
import searchApi from '../api/search/searchApi';

const store = configureStore({
    reducer: {
        [userApi.reducerPath]: userApi.reducer,
        [searchApi.reducerPath]: searchApi.reducer,
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat([
            userApi.middleware,
            searchApi.middleware,
        ]),
    devTools: true,
});

console.log('store created');

export default store;
export const { dispatch } = store;
