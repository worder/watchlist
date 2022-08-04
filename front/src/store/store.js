import { configureStore, combineReducers } from '@reduxjs/toolkit';

import userApi from '../api/user/userApi';
import searchApi from '../api/search/searchApi';
import listApi from '../api/list/listApi';

import userListCreateDialogSlice from '../app/Dialogs/UserListCreateDialog/userListCreateDialogSlice';

const rootReducer = combineReducers({
    [userApi.reducerPath]: userApi.reducer,
    [searchApi.reducerPath]: searchApi.reducer,
    [listApi.reducerPath]: listApi.reducer,
    dialogs: combineReducers({
        userListCreate: userListCreateDialogSlice,
    }),
});

const store = configureStore({
    reducer: rootReducer,
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat([
            userApi.middleware,
            searchApi.middleware,
            listApi.middleware,
        ]),
    devTools: true,
});

console.log('store created');

export default store;
export const { dispatch } = store;
