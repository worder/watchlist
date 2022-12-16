import { configureStore, combineReducers } from '@reduxjs/toolkit';

import userApi from '../api/user/userApi';
import searchApi from '../api/search/searchApi';
import listApi from '../api/list/listApi';

import userListCreateDialogSlice from '../app/Dialogs/UserListCreateDialog/userListCreateDialogSlice';
import addToListDialogSlice from '../app/Dialogs/AddToListDialog/addToListDialogSlice';
import constsApi from '../api/env/constApi';

const rootReducer = combineReducers({
    [userApi.reducerPath]: userApi.reducer,
    [searchApi.reducerPath]: searchApi.reducer,
    [listApi.reducerPath]: listApi.reducer,
    [constsApi.reducerPath]: constsApi.reducer,
    dialogs: combineReducers({
        userListCreate: userListCreateDialogSlice,
        addToList: addToListDialogSlice,
    }),
});

const store = configureStore({
    reducer: rootReducer,
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat([
            userApi.middleware,
            searchApi.middleware,
            listApi.middleware,
            constsApi.middleware,
        ]),
    devTools: true,
});

export type RootState = ReturnType<typeof store.getState>;
export default store;
export const { dispatch } = store;
