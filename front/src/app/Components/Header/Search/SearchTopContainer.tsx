import React, { useEffect, useState } from 'react';
import styled from 'styled-components';

import { TextInput, Select, Button, LoadingOverlay } from '@mantine/core';

import SearchResultList from '../../Search/SearchResultList/SearchResultList';

import useSearch from '../../../../api/search/hooks/search';
import useSearchOptions from '../../../../api/search/hooks/searchOptions';

const SearchTopContainer = styled.div`
    display: flex;
    flex-flow: row;
    gap: 10px;
    position: relative;
`;

const SearchInputContainer = styled.div`
    width: 300px;
`;
const SearchApiContainer = styled.div`
    width: 150px;
`;

const setValueFromEvent = (set) => (e) => set(e.target.value);

const SearchTop = () => {
    const [term, setTerm] = useState<string>('');
    const [page, setPage] = useState<number>(1);
    const [isSearchResultVisible, setIsSearchResultVisible] =
        useState<boolean>(false);

    const {
        commitSearch,
        refetch,
        searchResult,
        isLoading: isSearchLoading,
        isReady: isSearchReady,
        isError: isSearchError,
        error: searchError,
    } = useSearch();

    const {
        isReady: isOptionsReady,
        apis,
        api,
        mediaType,
        selectMediaType,
        selectApi,
    } = useSearchOptions();

    const apisList = apis
        ? apis.map((api) => ({
              value: api.id,
              label: api.name_short,
          }))
        : [];

    const mediaTypesList = api
        ? api.media_types.map((type) => ({ value: type.id, label: type.name }))
        : [];

    const selectedMediaType = mediaType && mediaType.id;
    const selectedApi = api && api.id;

    const doSearch = () =>
        api &&
        mediaType &&
        commitSearch({ term, api: api.id, type: mediaType.id, page });

    useEffect(() => {
        doSearch();
    }, [page]);

    const onSearch = (e) => {
        e.preventDefault();
        setIsSearchResultVisible(true);
        if (isSearchError && term) {
            refetch();
        } else {
            doSearch();
        }
    };

    return (
        <form onSubmit={onSearch}>
            <SearchTopContainer>
                <LoadingOverlay visible={!isOptionsReady} />
                <SearchInputContainer>
                    <TextInput
                        placeholder="Поиск"
                        name="term"
                        value={term}
                        onChange={setValueFromEvent(setTerm)}
                    />
                </SearchInputContainer>
                <SearchApiContainer>
                    <Select
                        value={selectedApi}
                        onChange={selectApi}
                        data={apisList}
                    />
                </SearchApiContainer>
                <Select
                    value={selectedMediaType}
                    onChange={selectMediaType}
                    data={mediaTypesList}
                />
                <Button type="submit">Search</Button>
            </SearchTopContainer>
            <SearchResultList
                isVisible={isSearchResultVisible}
                onHide={() => setIsSearchResultVisible(false)}
                page={page}
                onSetPage={setPage}
                result={searchResult}
                isReady={isSearchReady}
                isLoading={isSearchLoading}
                isError={isSearchError}
                error={searchError}
            />
        </form>
    );
};

export default SearchTop;
