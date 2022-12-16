import { createApi } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

import { SearchResult, SearchQueryParams } from './searchTypes';

const searchApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'searchApi',
    endpoints: (build) => ({
        search: build.query<SearchResult, SearchQueryParams>({
            query: ({ term, api, type, page }) => ({
                url: '/search',
                params: { api, term, type, page },
            }),
        }),
    }),
});

export const { useSearchQuery } = searchApi;

export const {
    useQueryState: useSearchQueryState,
    useQuerySubscription: useSearchQuerySubscription,
} = searchApi.endpoints.search;

export default searchApi;
