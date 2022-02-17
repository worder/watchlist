// import { createStore } from 'redux';
import { configureStore } from "@reduxjs/toolkit";

import {
  reducerPath as userApiReducerPath,
  reducer as userApiReducer,
  middleware as userApiMw,
} from "../api/user/userApi";

const store = configureStore({
  reducer: {
    [userApiReducerPath]: userApiReducer,
  },
  middleware: (getDefaultMiddleware) => getDefaultMiddleware().concat(userApiMw),
});

export default store;
