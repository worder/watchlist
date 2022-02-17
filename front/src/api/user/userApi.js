import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

const userApi = createApi({
    baseQuery: apiBaseQuery(),
    //   baseQuery: apiBaseQuery(),
    reducerPath: 'userApi',
    endpoints: (build) => ({
        getInfo: build.query({
            query: () => ({ url: '/user/info' }),
        }),
        login: build.mutation({
            query: (data) => ({
                url: '/user/signin',
                method: 'POST',
                data,
            }),
        }),
    }),
});

export const { useGetInfoQuery, useLoginMutation } = userApi;
export const { reducerPath, reducer, middleware } = userApi;
