import React, { useEffect, useState } from 'react';
import styled from 'styled-components';

import { TextInput, Select, LoadingOverlay } from '@mantine/core';

import { useGetSearchOptionsQuery } from '../../../api/search/searchApi';

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

const SearchBar = styled.input``;

const SearchTop = () => {
    const { data, isLoading, isFetching, isError, error } =
        useGetSearchOptionsQuery();

    const isReady = !isLoading && !isFetching && !isError;

    const [selectedApi, setSelectedApi] = useState(null);
    const [selectedMediaType, setSelectedMediaType] = useState(null);

    useEffect(() => {
        if (data && selectedApi) {
            console.log(data.find(val => val.api_id === selectedApi))
            setSelectedMediaType(data.find(val => val.api_id === selectedApi).media_types[0]);
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
        mediaTypesList = data.find(val => val.api_id === selectedApi).media_types;
        console.log(data.find(val => val.api_id === selectedApi))
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

    return (
        <SearchTopContainer>
            <LoadingOverlay visible={!isReady} />
            <SearchInputContainer>
                <TextInput
                    placeholder="Поиск"
                    seize="lg"
                    onFocus={onFocus}
                    onBlur={onBlur}
                />
            </SearchInputContainer>
            <SearchApiContainer>
                <Select value={selectedApi} onChange={setSelectedApi} data={apisList} />
            </SearchApiContainer>
            <Select value={selectedMediaType} onChange={setSelectedMediaType} data={mediaTypesList} />
        </SearchTopContainer>
    );
};

export default SearchTop;
