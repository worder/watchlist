import React from 'react';
import styled from 'styled-components';

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

    for (let i = 1; (i <= pages && i <= 20); i++) {
        buttons.push(
            page !== i ? (
                <PaginateButton
                    key={i}
                    type="button"
                    onClick={() => {
                        setPage(i);
                        return false;
                    }}
                >
                    {i}
                </PaginateButton>
            ) : (
                <PaginateCurrentPage key={i}>{i}</PaginateCurrentPage>
            )
        );
    }

    return <PaginateContainer>{buttons}</PaginateContainer>;
};

export default Paginate;