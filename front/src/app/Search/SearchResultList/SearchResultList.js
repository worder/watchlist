import React from 'react';
import styled, { css } from 'styled-components';

import SearchResultItem from './SearchResultItem';

const Container = styled.div`
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

const List = styled.div`
    width: 720px;
    border: 1px solid #000;
    background-color: #aaa;
    padding: 10px;
`;

const SearchResultList = ({ items, total, page }) => {
    return (
        <Container isVisible={items && items.length > 0}>
            <List>
                {items &&
                    items.map((item) => (
                        <SearchResultItem key={item.id} item={item} />
                    ))}
            </List>
        </Container>
    );
};

export default SearchResultList;
