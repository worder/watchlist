import React from 'react';
import styled from 'styled-components';

const ItemContainer = styled.div`
    margin: 5px;
    display: flex;
`;

const PosterContainer = styled.div``;

const InfoContainer = styled.div``;

const SearchResultItem = ({ item }) => (
    <ItemContainer>
        <PosterContainer>
            <img src={item.posters.s} />
        </PosterContainer>
        <InfoContainer>
            <div>Title: {item.title}</div>
            <div>Title original: {item.title_original}</div>
            <div>Release date: {item.release_date}</div>
        </InfoContainer>
    </ItemContainer>
);

export default SearchResultItem;
