import { createApi } from '@reduxjs/toolkit/query/react';
import apiBaseQuery from '../client';

export interface ApiMediaType {
    id: string;
    name: string;
}

export interface Api {
    id: string;
    media_types: ApiMediaType[];
    name: string;
    name_short: string;
}

export type ListItemStatus = [statusId: number, statusMnemonics: string];

export interface Consts {
    list_item_statuses: ListItemStatus[];
    apis: Api[];
}

const constApi = createApi({
    baseQuery: apiBaseQuery(),
    reducerPath: 'constApi',
    endpoints: (build) => ({
        getConsts: build.query<Consts, void>({
            query: () => ({ url: `/consts` }),
        }),
    }),
});

export const { useGetConstsQuery } = constApi;

export default constApi;
