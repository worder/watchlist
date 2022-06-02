import React, { useEffect, useState } from 'react';
import styled from 'styled-components';

import { TextInput, Select, Button, LoadingOverlay } from '@mantine/core';

import SearchResultList from '../../Search/SearchResultList/SearchResultList';

import {
    useGetSearchOptionsQuery,
    useSearchMutation,
} from '../../../api/search/searchApi';

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

const SearchTop = () => {
    const { data, isLoading, isFetching, isError, error } =
        useGetSearchOptionsQuery();

    const [doSearch, searchResult] = useSearchMutation();

    const { isSuccess: isSearchSuccess, data: searchData } = searchResult;

    console.log(searchResult);

    const isReady = !isLoading && !isFetching && !isError;

    const [selectedApi, setSelectedApi] = useState(null);
    const [selectedMediaType, setSelectedMediaType] = useState(null);

    useEffect(() => {
        if (data && selectedApi) {
            console.log(data.find((val) => val.api_id === selectedApi));
            setSelectedMediaType(
                data.find((val) => val.api_id === selectedApi).media_types[0]
            );
        }
    }, [selectedApi]);

    const apisList = data
        ? data.map((api) => ({
              value: api.api_id,
              label: api.name_short,
          }))
        : [];

    let mediaTypesList = [];
    if (data && data.length > 0 && selectedApi) {
        mediaTypesList = data.find(
            (val) => val.api_id === selectedApi
        ).media_types;
    }

    if (data && !selectedApi) {
        setSelectedApi(data[0].api_id);
    }

    const onFocus = () => {
        console.log('focus');
    };

    const onBlur = () => {
        console.log('blur');
    };

    const onSearch = (e) => {
        e.preventDefault();
        var data = new FormData(e.target);
        const term = data.get('term');
        doSearch({ term, api: selectedApi, type: selectedMediaType });
    };

    return (
        <form onSubmit={onSearch}>
            <SearchTopContainer>
                <LoadingOverlay visible={!isReady} />
                <SearchInputContainer>
                    <TextInput placeholder="Поиск" name="term" seize="lg" />
                </SearchInputContainer>
                <SearchApiContainer>
                    <Select
                        value={selectedApi}
                        onChange={setSelectedApi}
                        data={apisList}
                    />
                </SearchApiContainer>
                <Select
                    value={selectedMediaType}
                    onChange={setSelectedMediaType}
                    data={mediaTypesList}
                />
                <Button type="submit">Search</Button>
            </SearchTopContainer>
            {isSearchSuccess && (
                <SearchResultList
                    items={searchData.data.items}
                    total={searchData.data.total}
                    page={searchData.data.page}
                />
            )}
        </form>
    );
};

export default SearchTop;
