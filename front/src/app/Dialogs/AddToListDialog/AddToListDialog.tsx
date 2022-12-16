import { SegmentedControl, Select } from '@mantine/core';
import React from 'react';
import { connect, ConnectedProps } from 'react-redux';
import { Consts, useGetConstsQuery } from '../../../api/env/constApi';
import { useGetUserListsQuery } from '../../../api/list/listApi';
import useGetCurrentUserLists from '../../../api/list/useGetCurrentUserLists';
import { RootState } from '../../../store/store';

import Dialog from '../../Dialog/Dialog';

import { hide, getIsVisible } from './addToListDialogSlice';

const connector = connect(
    (state: RootState) => ({ isVisible: getIsVisible(state) }),
    (dispatch) => ({ onHide: () => dispatch(hide()) })
);

type ReduxProps = ConnectedProps<typeof connector>;

interface Props extends ReduxProps {}

const AddToListDialog = ({ isVisible, onHide }: Props) => {
    const { data } = useGetCurrentUserLists();

    const { data: consts } = useGetConstsQuery();

    let lists: { value: string; label: string }[] = [];
    let defaultList: string | null = null;
    if (data) {
        data.forEach((list) => {
            lists.push({ value: `${list.listId}`, label: list.title });
            if (!defaultList) {
                defaultList = `${list.listId}`;
            }
        });
    }

    let statuses: any = [];
    if (consts) {
        consts.list_item_statuses.map((status) => {
            statuses.push({ label: status[1], value: status[0] });
        });
    }

    return (
        <Dialog.DialogContainer isVisible={isVisible}>
            <Dialog.DialogTitleContainer>
                <Dialog.DialogTitle>Добавить в список</Dialog.DialogTitle>
            </Dialog.DialogTitleContainer>
            <Dialog.DialogContentContainer>
                {data && <Select data={lists} defaultValue={defaultList} />}
                <SegmentedControl data={statuses} />
            </Dialog.DialogContentContainer>
            <Dialog.DialogButtonsContainer>
                <Dialog.Button>Добавть</Dialog.Button>
                <Dialog.Button onClick={() => onHide()}>Отмена</Dialog.Button>
            </Dialog.DialogButtonsContainer>
        </Dialog.DialogContainer>
    );
};

export default connector(AddToListDialog);
