import { configureStore, combineReducers } from '@reduxjs/toolkit';

import userApi from '../api/user/userApi';
import searchApi from '../api/search/searchApi';
import listApi from '../api/list/listApi';

import userListCreateDialogSlice from '../app/Components/Dialogs/UserListCreateDialog/userListCreateDialogSlice';
import addToListDialogSlice from '../app/Components/Dialogs/AddToListDialog/addToListDialogSlice';
import constsApi from '../api/env/constApi';
import listItemsApi from '../api/listItems/listItemsApi';

const rootReducer = combineReducers({
    [userApi.reducerPath]: userApi.reducer,
    [searchApi.reducerPath]: searchApi.reducer,
    [listApi.reducerPath]: listApi.reducer,
    [constsApi.reducerPath]: constsApi.reducer,
    [listItemsApi.reducerPath]: listItemsApi.reducer,
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
            listItemsApi.middleware,
        ]),
    devTools: true,
});

export type RootState = ReturnType<typeof store.getState>;
export default store;
export const { dispatch } = store;
