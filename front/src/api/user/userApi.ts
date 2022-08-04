import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

import { UserInfoResponse } from './userTypes';

type SigninProps = { login: string; password: string };

type ApiResponse = string | [string, any];

const userApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'userApi',
    tagTypes: ['User'],
    endpoints: (build) => ({
        getInfo: build.query<UserInfoResponse, void>({
            query: () => ({ url: '/user/info' }),
            providesTags: ['User'],
        }),
        signin: build.mutation<ApiResponse, SigninProps>({
            query: (data) => ({
                url: '/user/signin',
                method: 'post',
                data,
            }),
            invalidatesTags: ['User'],
        }),
        signout: build.mutation<ApiResponse, void>({
            query: () => ({
                url: '/user/signout',
                method: 'get',
            }),
            invalidatesTags: ['User'],
        }),
    }),
});

export const {
    useGetInfoQuery,
    useSigninMutation,
    useSignoutMutation,
    reducerPath,
    reducer,
    middleware,
} = userApi;

export default userApi;
