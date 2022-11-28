import axios from 'axios';
import type { BaseQueryFn } from '@reduxjs/toolkit/query';

type Method = 'get' | 'put' | 'post' | 'patch' | 'delete';

interface Args {
    baseUrl?: string;
}

interface QueryArgs {
    url: string;
    method?: Method;
    data?: any;
    params?: object;
}

interface Error {
    data: any;
    status: number;
}

const apiBaseQuery = ({ baseUrl } = { baseUrl: '/api' }) => {
    const apiBaseQueryFunc: BaseQueryFn<QueryArgs, unknown, Error> = async ({
        url,
        method,
        data,
        params,
    }: QueryArgs) => {
        try {
            const result = await axios({
                url: baseUrl + url,
                method,
                data,
                params,
            });
            return { data: result.data };
        } catch (axiosError) {
            let err = axiosError;
            return {
                error: {
                    status: err.response?.status,
                    data: err.response?.data,
                },
            };
        }
    };

    return apiBaseQueryFunc;
};

export default apiBaseQuery;
