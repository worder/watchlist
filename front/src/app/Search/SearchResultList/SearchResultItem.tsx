import React from 'react';
import styled from 'styled-components';
import { SearchItem } from '../../../api/search/searchTypes';

const ItemContainer = styled.div`
    margin: 5px;
    padding-top: 5px;
    display: flex;

    & + & {
        border-top: 1px solid #999;
    }
`;

const PosterContainer = styled.div`
    height: 100px;
    min-width: 65px;
    background-color: #aaa;

    img {
        height: 100%;
    }
`;

const InfoContainer = styled.div`
    margin-left: 15px;
`;

const ItemTitle = styled.div`
    font-weight: bold;
`;

const ItemTitleOriginal = styled.div`
`;

const ItemReleaseDate = styled.div`
`;

interface Props {
    item: SearchItem;
}

const SearchResultItem = ({ item }: Props) => (
    <ItemContainer>
        <PosterContainer>
            {item.posters && <img src={item.posters.s} />}
        </PosterContainer>
        <InfoContainer>
            <ItemTitle>{item.title}</ItemTitle>
            <ItemTitleOriginal>{item.title_original}</ItemTitleOriginal>
            <ItemReleaseDate>{item.release_date}</ItemReleaseDate>
            <div>{`${item.api} - ${item.type} - ${item.id}`}</div>
        </InfoContainer>
    </ItemContainer>
);

export default SearchResultItem;
