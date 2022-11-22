import axios from 'axios';

type Method = "get" | "put" | "post" | "patch" | "delete";

interface QueryParams {
    url: string,
    method?: Method,
    data?: any,
    params?: object
}

interface Error {
    data: string,
    status: number;
}

const apiBaseQuery =
    ({ baseUrl } = { baseUrl: '/api' }) =>
    async ({ url, method, data, params }: QueryParams) => {
        try {
            const result = await axios({
                url: baseUrl + url,
                method,
                data,
                params
            });
            return { data: result.data };
        } catch (axiosError) {
            let err = axiosError;
            return {
                error: {
                    status: err.response?.status,
                    data: err.response?.data,
                } as Error,
            };
        }
    };

export default apiBaseQuery;
