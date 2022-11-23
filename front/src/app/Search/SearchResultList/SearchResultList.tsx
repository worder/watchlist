import React from 'react';
import styled, { css } from 'styled-components';
import { SearchResult } from '../../../api/search/searchTypes';

import SearchResultItem from './SearchResultItem';

interface PlaceholderProps {
    isVisible: boolean;
}

const Placeholder = styled.div<Partial<PlaceholderProps>>`
    position: absolute;
    top: 60px;
    left: 0px;
    width: 100%;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    ${(p) =>
        !p.isVisible &&
        css`
            display: none;
        `}
`;

const Container = styled.div`
    width: 720px;
    border: 1px solid #000;
    background-color: #eee;
`;

const List = styled.div`
    padding: 10px;
`;

const Title = styled.div`
    padding: 10px;
    display: flex;
    border-bottom: 1px solid #444;
`;

const TitleInfo = styled.div`
    width: 100%;
`;

const CloseButton = styled.button``;

interface Props {
    result: SearchResult | null;
    isReady: boolean;
    isLoading: boolean;
    isVisible: boolean;
    onHide: () => void;
}

const SearchResultList = ({ result, isVisible, isLoading, onHide }: Props) => {
    const { items } = result ?? {};
    const visible = isVisible && (items && items.length > 0) || isLoading;
    return (
        <Placeholder isVisible={visible}>
            <Container>
                <Title>
                    <TitleInfo>{`Найдено: ${result?.total}`}</TitleInfo>
                    <CloseButton type="button" onClick={onHide}>Закрыть</CloseButton>
                </Title>
                <List>
                    {items &&
                        items.map((item) => (
                            <SearchResultItem key={item.id} item={item} />
                        ))}
                </List>
            </Container>
        </Placeholder>
    );
};

export default SearchResultList;
