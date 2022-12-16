import { useState, useEffect } from 'react';
import { Api, ApiMediaType, Consts, useGetConstsQuery } from '../../env/constApi';

interface UseSearchOptionsResult {
    isReady: boolean;
    isLoading: boolean;
    isError: boolean;
    apis: Api[];
    selectApi: (id: string) => void;
    selectMediaType: (id: string) => void;
    api: Api | null;
    mediaType: ApiMediaType | null;
}

const useSearchOptions = (): UseSearchOptionsResult => {
    const { data, isFetching, isLoading, isSuccess, isError } =
        useGetConstsQuery();

    const isReady = isSuccess && !isFetching && !isLoading && !isError;

    const [apis, setApis] = useState<Consts['apis']>([]);
    const [api, setApi] = useState<Api | null>(null);
    const [mediaType, setMediaType] = useState<ApiMediaType | null>(
        null
    );

    useEffect(() => {
        if (isReady && data !== undefined) {
            setApis(data.apis);
        }
    }, [data, isReady]);

    useEffect(() => {
        if (api === null && apis.length > 0) {
            setApi(apis[0]);
        }
    }, [apis]);

    useEffect(() => {
        if (api && api.media_types.length > 0) {
            setMediaType(api.media_types[0]);
        }
    }, [api]);

    const selectApi = (id) => setApi(apis.find((api) => api.id === id) || null);

    const selectMediaType = (id) =>
        setMediaType(api?.media_types.find((type) => type.id === id) || null);

    return {
        isReady,
        isLoading: isLoading || isFetching,
        isError,
        apis,
        selectApi,
        selectMediaType,
        api,
        mediaType,
    };
};

export default useSearchOptions;
