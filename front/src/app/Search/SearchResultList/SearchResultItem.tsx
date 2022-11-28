import React from 'react';
import { connect, ConnectedProps } from 'react-redux';
import styled from 'styled-components';
import { SearchItem } from '../../../api/search/searchTypes';
import { RootState } from '../../../store/store';

import {
    show as showAddToListDialog,
    getIsVisible,
} from '../../Dialogs/AddToListDialog/addToListDialogSlice';

const ItemContainer = styled.div`
    margin: 5px;
    padding-top: 5px;
    display: flex;
    position: relative;

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

const ItemTitleOriginal = styled.div``;

const ItemReleaseDate = styled.div``;

const ButtonsContainer = styled.div`
    position: absolute;
    top: 4px;
    right: 4px;
`;

const connector = connect(
    (state: RootState) => ({
        isVisible: getIsVisible(state),
    }),
    (dispatch) => ({
        onShowAddToListDialog: ({ api, mediaId }) =>
            dispatch(showAddToListDialog({ api, mediaId })),
    })
);

type ReduxProps = ConnectedProps<typeof connector>;

interface Props extends ReduxProps {
    item: SearchItem;
}

const SearchResultItem = ({ item, onShowAddToListDialog }: Props) => {
    const onAddToList = () => {
        onShowAddToListDialog({ api: item.api, mediaId: item.id });
        console.log(item.api, item.id);
        return false;
    };

    return (
        <ItemContainer>
            <PosterContainer>
                {item.posters && <img src={item.posters.s} />}
            </PosterContainer>
            <InfoContainer>
                <ItemTitle>{item.title}</ItemTitle>
                <ItemTitleOriginal>{item.title_original}</ItemTitleOriginal>
                <ItemReleaseDate>{item.release_date}</ItemReleaseDate>
            </InfoContainer>
            <ButtonsContainer>
                <button
                    type="button"
                    onClick={onAddToList}
                >{`${item.api} - ${item.type} - ${item.id}`}</button>
            </ButtonsContainer>
        </ItemContainer>
    );
};

export default connector(SearchResultItem);
