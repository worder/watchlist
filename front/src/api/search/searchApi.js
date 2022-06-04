import { createApi } from '@reduxjs/toolkit/query/react';
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
        search: build.query({
            query: ({ term, api, type }) => ({
                url: '/search',
                params: {
                    api,
                    term,
                    type,
                },
            }),
        }),
        // search: build.mutation({
        //     query: ({ term, api, type }) => ({
        //         url: '/search',
        //         params: {
        //             api,
        //             term,
        //             type,
        //         },
        //     }),
        // }),
    }),
});

export const {
    useGetSearchOptionsQuery,
    useSearchQuery,
    // useSearchMutation,
} = searchApi;

export const {
    useQueryState: useSearchQueryState,
    useQuerySubscription: useSearchQuerySubscription,
} = searchApi.endpoints.search;

export default searchApi;
