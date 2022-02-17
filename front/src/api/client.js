import axios from 'axios';

const apiBaseQuery =
    ({ baseUrl } = { baseUrl: '/api' }) =>
    async ({ url, method, data }) => {
        try {
            const result = await axios({
                url: baseUrl + url,
                method,
                data,
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
