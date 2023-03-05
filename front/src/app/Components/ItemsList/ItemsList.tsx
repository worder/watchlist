import React from 'react';
import { ListItem } from '../../../api/listItems/listItemsType';
import styled from 'styled-components';

const ItemContainer = styled.div`
    display: flex;
    padding: 5px 0px;
`;

const PosterContainer = styled.div`
    height: 120px;
    width: 90px;
    display: flex;
    justify-content: center;
`;

const InfoContainer = styled.div`
    display: flex;
    flex-direction: column;
`;

const Poster = styled.img`
    max-height: 120px;
`;

const InfoTitle = styled.div`
    font-size: 18pt;
`;

const InfoTitleOriginal = styled.div`
    font-size: 10pt;
    color: #333;
`;

// const InfoYear = styled.div`
//     font-size: 10pt;
// `;

interface ItemsListProps {
    items: ListItem[];
    total: number;
    page: number;
    pages: number;
}

const ItemsList = ({ items, total, page, pages }: ItemsListProps) => {
    return (
        <div>
            {items.map((item) => (
                <ItemContainer key={item.id}>
                    <PosterContainer>
                        {item.posters.s && <Poster src={item.posters.s} />}
                    </PosterContainer>
                    <InfoContainer>
                        <InfoTitle>{item.title}</InfoTitle>
                        <InfoTitleOriginal>{item.release_date}, {item.original_title}</InfoTitleOriginal>
                    </InfoContainer>
                </ItemContainer>
            ))}
        </div>
    );
};

export default ItemsList;
