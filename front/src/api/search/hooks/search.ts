import { useEffect, useState } from 'react';
import { string } from 'zod';

import { useSearchQuery } from '../searchApi';

import { SearchResult, SearchQueryParams } from '../searchTypes';

interface UseSearchReturn {
    commitSearch: (options: SearchQueryParams) => void;
    clearSearch: () => void;
    refetch: () => void;
    searchResult: SearchResult | null;
    isReady: boolean;
    isLoading: boolean;
    isError: boolean;
    error: string[] | null;
}

const useSearch = (): UseSearchReturn => {
    const [searchOptions, setSearchOptions] =
        useState<SearchQueryParams | null>(null);

    const [searchResult, setSearchResult] = useState<SearchResult | null>(null);

    const clearSearch = () => {
        setSearchResult(null);
        setSearchOptions(null);
    };

    const { term, api, type, page } = searchOptions ?? {
        term: '',
        api: '',
        type: '',
        page: 1,
    };

    const searchQueryResult = useSearchQuery(
        { term, api, type, page },
        { skip: searchOptions === null }
    );

    const {
        data: searchResultData,
        isSuccess,
        isUninitialized,
        isFetching,
        isLoading,
        isError,
        error: rawError,
        refetch,
    } = searchQueryResult;

    const isReady = isSuccess && !isUninitialized && !isFetching && !isLoading;

    useEffect(() => {
        if (searchResult && isError) {
            setSearchResult(null);
        }
    }, [isError]);

    useEffect(() => {
        if (isReady && searchResultData) {
            setSearchResult(searchResultData);
        }
    }, [isReady, searchResultData]);

    return {
        commitSearch: setSearchOptions,
        clearSearch,
        refetch,
        searchResult,
        isLoading: isLoading || isFetching,
        isReady,
        isError,
        error: rawError && 'data' in rawError && rawError.data,
    };
};

export default useSearch;
