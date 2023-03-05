import { createApi } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

import { ListItemsResult, IndexListItemsProps, ListItemPutProps } from './listItemsType';

const listItemsApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'listItemsApi',
    tagTypes: ['ListItems', 'IndexListItems'],
    endpoints: (build) => ({
        getListItems: build.query<ListItemsResult, number>({
            query: (listId) => ({ url: `/list-items/${listId}` }),
            providesTags: ['ListItems'],
        }),
        putListItem: build.mutation<null, ListItemPutProps>({
            query: (data) => ({
                url: `/list-items/${data.listId}`,
                method: 'put',
                data,
            }),
            invalidatesTags: ['ListItems'],
        }),
        getIndexListItems: build.query<ListItemsResult, IndexListItemsProps>({
            query: (data) => ({
                url: `/index-list-items/${data.userId}`,
                method: 'get',
            }),
            providesTags: ['IndexListItems']
        })
    }),
});

export const { usePutListItemMutation, useGetIndexListItemsQuery, useGetListItemsQuery } = listItemsApi;

export default listItemsApi;
