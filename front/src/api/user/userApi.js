import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

const userApi = createApi({
    baseQuery: apiBaseQuery(),
    //   baseQuery: apiBaseQuery(),
    reducerPath: 'userApi',
    tagTypes: ['User'],
    endpoints: (build) => ({
        getInfo: build.query({
            query: () => ({ url: '/user/info' }),
            providesTags: ['User'],
        }),
        signin: build.mutation({
            query: (data) => ({
                url: '/user/signin',
                method: 'POST',
                data,
            }),
            invalidatesTags: ['User'],
        }),
        signout: build.mutation({
            query: () => ({
                url: '/user/signout',
                method: 'GET',
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
