import axios from 'axios';

type Method = "get" | "put" | "post" | "patch" | "delete";

interface QueryParams {
    url: string,
    method?: Method,
    data?: object | string,
    params?: object
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
                },
            };
        }
    };

export default apiBaseQuery;
