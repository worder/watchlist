import { useEffect, useState } from 'react';
import { string } from 'zod';

import { useSearchQuery } from '../searchApi';

import { SearchResult, SearchQueryParams } from '../searchTypes';

interface UseSearchReturn {
    commitSearch: (options: SearchQueryParams) => void;
    clearSearch: () => void;
    searchResult: SearchResult | null;
    isReady: boolean;
    isLoading: boolean;
    isError: boolean;
    error: string | null;
}

const useSearch = (): UseSearchReturn => {
    const [searchOptions, setSearchOptions] = useState<SearchQueryParams | null>(
        null
    );

    const [searchResult, setSearchResult] = useState<SearchResult | null>(null);

    const clearSearch = () => {
        setSearchResult(null);
        setSearchOptions(null);
    };

    const { term, api, type, page } = searchOptions ?? {
        term: '',
        api: '',
        type: '',
        page: 1
    };

    const searchQueryResult = useSearchQuery(
        { term, api, type, page },
        { skip: searchOptions === null }
    );

    const { isSuccess, isUninitialized, isFetching, isLoading, isError } =
        searchQueryResult;

    const { data: searchResultData } = searchQueryResult;

    console.log(searchResultData);

    const isReady = isSuccess && !isUninitialized && !isFetching && !isLoading;

    useEffect(() => {
        if (isReady && searchResultData) {
            setSearchResult(searchResultData);
        }
    }, [isReady, searchResultData]);

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
