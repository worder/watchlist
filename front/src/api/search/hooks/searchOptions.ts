import { useState, useEffect } from 'react';

import { useGetSearchOptionsQuery } from '../searchApi';

import {
    SearchOptionsResult,
    SearchOptionsApi,
    SearchOptionsMediaType,
} from '../searchTypes';

interface UseSearchOptionsResult {
    isReady: boolean;
    isLoading: boolean;
    isError: boolean;
    apis: SearchOptionsResult;
    selectApi: (id: string) => void;
    selectMediaType: (id: string) => void;
    api: SearchOptionsApi | null;
    mediaType: SearchOptionsMediaType | null;
}

const useSearchOptions = (): UseSearchOptionsResult => {
    const { data, isFetching, isLoading, isSuccess, isError } =
        useGetSearchOptionsQuery();

    const isReady = isSuccess && !isFetching && !isLoading && !isError;

    const [apis, setApis] = useState<SearchOptionsResult>([]);
    const [api, setApi] = useState<SearchOptionsApi | null>(null);
    const [mediaType, setMediaType] = useState<SearchOptionsMediaType | null>(
        null
    );

    useEffect(() => {
        if (isReady) {
            setApis(data);
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

    const selectApi = (id) => setApi(apis.find((api) => api.id === id));
    const selectMediaType = (id) =>
        setMediaType(api.media_types.find((type) => type.id === id));

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