import { useEffect, useState } from 'react';
import { string } from 'zod';

import { useSearchQuery } from '../searchApi';

import { SearchResult } from '../searchTypes';

interface SearchOptions {
    term: string;
    api: string;
    type: string;
}

interface UseSearchReturn {
    commitSearch: (options: SearchOptions) => void;
    clearSearch: () => void;
    searchResult: SearchResult | null;
    isReady: boolean;
    isLoading: boolean;
    isError: boolean;
    error: string | null;
}

const useSearch = (): UseSearchReturn => {
    const [searchOptions, setSearchOptions] = useState<SearchOptions | null>(
        null
    );

    const [searchResult, setSearchResult] = useState<SearchResult | null>(null);

    const clearSearch = () => {
        setSearchResult(null);
        setSearchOptions(null);
    };

    const { term, api, type } = searchOptions ?? {};

    const searchQueryResult = useSearchQuery(
        { term, api, type },
        { skip: searchOptions === null }
    );

    const { isSuccess, isUninitialized, isFetching, isLoading, isError } =
        searchQueryResult;

    const { data: searchResultData } = searchQueryResult;

    const isReady =
        isSuccess && !isUninitialized && !isFetching && !isLoading;

    useEffect(() => {
        if (isReady) {
            setSearchResult(searchResultData);
        }
    }, [isReady]);

    return {
        commitSearch: setSearchOptions,
        clearSearch,
        searchResult,
        isLoading: isLoading || isFetching,
        isReady,
        isError,
        error: null,
    };
};

export default useSearch;
