import { createApi, } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

const searchApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'searchApi',
    // tagTypes: ['User'],
    endpoints: (build) => ({
        getSearchOptions: build.query({
            query: () => ({ url: '/search/options' }),
            // providesTags: ['User'],
        }),
        // signin: build.mutation({
        //     query: (data) => ({
        //         url: '/user/signin',
        //         method: 'POST',
        //         data,
        //     }),
        //     invalidatesTags: ['User'],
        // }),
        // signout: build.mutation({
        //     query: () => ({
        //         url: '/user/signout',
        //         method: 'GET',
        //     }),
        //     invalidatesTags: ['User'],
        // }),
    }),
});

export const {
    useGetSearchOptionsQuery,
    // useGetInfoQuery,
    // useSigninMutation,
    // useSignoutMutation,
} = searchApi;

export default searchApi;
