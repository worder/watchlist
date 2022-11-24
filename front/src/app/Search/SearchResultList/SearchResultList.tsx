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
    max-height: 500px;
    overflow: auto;
`;

const Title = styled.div`
    padding: 10px;
    display: flex;
    border-bottom: 1px solid #444;
`;

const TitleInfo = styled.div`
    width: 100%;
`;

const Footer = styled.div`
    border-top: 1px solid #444;
`;

const CloseButton = styled.button``;

const PaginateContainer = styled.div`
    display: flex;
    padding: 10px;
`;
const PaginateButton = styled.button`
    padding: 6px;
    border: none;
    font-size: 16px;
    background: none;
    text-decoration: underline;
    cursor: pointer;
`;
const PaginateCurrentPage = styled.div`
    font-size: 16px;
    padding: 6px;
    color: #989587;
`;

const Paginate = ({ pages, page, setPage }) => {
    let buttons: JSX.Element[] = [];

    for (let i = 1; i <= pages; i++) {
        buttons.push(
            page !== i ? (
                <PaginateButton
                    type="button"
                    onClick={() => {
                        setPage(i);
                        return false;
                    }}
                >
                    {i}
                </PaginateButton>
            ) : (
                <PaginateCurrentPage>{i}</PaginateCurrentPage>
            )
        );
    }

    return <PaginateContainer>{buttons}</PaginateContainer>;
};

interface Props {
    result: SearchResult | null;
    isReady: boolean;
    isLoading: boolean;
    isVisible: boolean;
    page: number;
    onHide: () => void;
    onSetPage: (page: number) => void;
}

const SearchResultList = ({
    result,
    isVisible,
    isLoading,
    onHide,
    onSetPage,
    page,
}: Props) => {
    const { items, pages } = result ?? {};
    const visible = (isVisible && items && items.length > 0) || isLoading;
    return (
        <Placeholder isVisible={visible}>
            <Container>
                <Title>
                    <TitleInfo>
                        {isLoading
                            ? 'Загрузка...'
                            : `Найдено: ${result?.total}`}
                    </TitleInfo>

                    <CloseButton type="button" onClick={onHide}>
                        Закрыть
                    </CloseButton>
                </Title>
                <List>
                    {items &&
                        items.map((item) => (
                            <SearchResultItem key={item.id} item={item} />
                        ))}
                </List>
                {pages && pages > 1 && (
                    <Footer>
                        <Paginate
                            pages={pages}
                            page={page}
                            setPage={onSetPage}
                        />
                    </Footer>
                )}
            </Container>
        </Placeholder>
    );
};

export default SearchResultList;
