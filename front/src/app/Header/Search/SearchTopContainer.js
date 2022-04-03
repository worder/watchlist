import React, { useState } from 'react';
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

    const [selectValue, setSelectValue] = useState(null);
    const selectData = data
        ? data.map((api) => ({
              value: api.api_id,
              label: api.name_short,
          }))
        : [];
    
    if (data && !selectValue) {
        setSelectValue(data[0].api_id);
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
                <Select value={selectValue} onChange={setSelectValue} data={selectData} />
            </SearchApiContainer>
        </SearchTopContainer>
    );
};

export default SearchTop;
