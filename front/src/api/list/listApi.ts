import { createApi } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

import { UserListsResult } from './listsTypes';

const listsApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'listApi',
    endpoints: (build) => ({
        getUserLists: build.query<UserListsResult, number>({
            query: (userId) => ({ url: `/user-lists/${userId}` }),
        }),
        createUserList: build.mutation({
            query: (data) => ({
                url: '/put',
                data
            })
        }),
        // search: build.query<
        //     SearchResult,
        //     { term: string; api: string; type: string }
        // >({
        //     query: ({ term, api, type }) => ({
        //         url: '/search',
        //         params: { api, term, type },
        //     }),
        // }),
    }),
});

export const { useGetUserListsQuery } = listsApi;

export default listsApi;
