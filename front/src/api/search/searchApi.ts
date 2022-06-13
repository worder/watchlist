import { createApi } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

import { SearchResult, SearchOptionsResult } from './searchTypes';

const searchApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'searchApi',
    endpoints: (build) => ({
        getSearchOptions: build.query<SearchOptionsResult, void>({
            query: () => ({ url: '/search/options' }),
        }),
        search: build.query<
            SearchResult,
            { term: string; api: string; type: string }
        >({
            query: ({ term, api, type }) => ({
                url: '/search',
                params: { api, term, type },
            }),
        }),
    }),
});

export const { useGetSearchOptionsQuery, useSearchQuery } = searchApi;

export const {
    useQueryState: useSearchQueryState,
    useQuerySubscription: useSearchQuerySubscription,
} = searchApi.endpoints.search;

export default searchApi;
