import { createApi } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

import { UserListsResult } from './listsTypes';

const listsApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'listApi',
    tagTypes: ['UserLists'],
    endpoints: (build) => ({
        getUserLists: build.query<UserListsResult, number>({
            query: (userId) => ({ url: `/user-lists/${userId}` }),
            providesTags: ['UserLists'],
        }),
        createUserList: build.mutation<null, { title: string; desc: string }>({
            query: (data) => ({
                url: '/list',
                method: 'put',
                data,
            }),
            invalidatesTags: ['UserLists'],
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

export const { useGetUserListsQuery, useCreateUserListMutation } = listsApi;

export default listsApi;
