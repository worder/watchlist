import 'dayjs/locale/ru';
import { Button, Select } from '@mantine/core';
import { DatePicker } from '@mantine/dates';
import React, { useEffect, useState } from 'react';
import { connect, ConnectedProps } from 'react-redux';
import { ListItemStatus, useGetConstsQuery } from '../../../../api/env/constApi';
import { UserList } from '../../../../api/list/listsTypes';
import useGetCurrentUserLists from '../../../../api/list/useGetCurrentUserLists';
import { RootState } from '../../../../store/store';

import Dialog from '../../Dialog/Dialog';

import { hide, getIsVisible, getDetails } from './addToListDialogSlice';
import { useForm } from '@mantine/form';
import { usePutListItemMutation } from '../../../../api/listItems/listItemsApi';

const connector = connect(
    (state: RootState) => ({
        isVisible: getIsVisible(state),
        details: getDetails(state),
    }),
    (dispatch) => ({ onHide: () => dispatch(hide()) })
);

type ReduxProps = ConnectedProps<typeof connector>;

interface Props extends ReduxProps {}

interface Option {
    value: string;
    label: string;
}

function buildListOptions<ItemType>(
    items: ItemType[],
    getValue: (item: ItemType) => string,
    getTitle: (item: ItemType) => string,
    isDefault: (item: ItemType) => boolean = () => true
): [Option[], Option | null] {
    let options: Option[] = [];
    let defaultOption: Option | null = null;
    if (items) {
        items.forEach((item) => {
            const option = { label: getTitle(item), value: getValue(item) };
            options.push(option);
            if (!defaultOption && isDefault(item)) {
                defaultOption = option;
                // console.log(defaultOption);
            }
        });
    }
    return [options, defaultOption];
}

interface FormValues {
    list: string;
    status: string;
    date: Date;
}

const AddToListDialog = ({ isVisible, onHide, details }: Props) => {
    const { data: lists, isSuccess: okLists } = useGetCurrentUserLists();
    const { data: consts, isSuccess: okConsts } = useGetConstsQuery();
    const isReady = okLists && okConsts;

    const [putListItem, putListItemResult] = usePutListItemMutation();

    // console.log(putListItemResult);

    const [listOptions, listDefaultOption] = buildListOptions<UserList>(
        lists ? lists : [],
        (list) => `${list.listId}`,
        (list) => list.title
    );

    const [statusOptions, statusDefaultOption] =
        buildListOptions<ListItemStatus>(
            consts ? consts.list_item_statuses : [],
            (item) => `${item[0]}`,
            (item) => item[1],
            (item) => {
                // console.log(item);
                return item[0] == 2;
            } // planned
        );

    const form = useForm<FormValues>();

    useEffect(() => {
        if (isVisible) {
            form.setValues({
                list: `${listDefaultOption?.value}`,
                status: `${statusDefaultOption?.value}`,
                date: new Date(),
            });
        }
    }, [isVisible]);

    const onAddToList = (values: FormValues) => {
        if (
            details.api &&
            details.mediaId &&
            details.type &&
            values.list &&
            values.status &&
            values.date
        ) {
            putListItem({
                api: details.api,
                mediaId: `${details.mediaId}`,
                mediaType: details.type,
                listId: Number(values.list),
                status: Number(values.status),
                date: values.date.getTime() / 1000,
            });
        }
    };

    return (
        <Dialog.DialogContainer isVisible={isVisible}>
            <form onSubmit={form.onSubmit(onAddToList)}>
                <Dialog.DialogTitleContainer>
                    <Dialog.DialogTitle>Добавить в список</Dialog.DialogTitle>
                </Dialog.DialogTitleContainer>
                {isReady && (
                    <Dialog.DialogContentContainer>
                        <Select
                            label="Добавить в список"
                            name="list"
                            data={listOptions}
                            {...form.getInputProps('list')}
                        />
                        <Select
                            label="Статус"
                            name="status"
                            data={statusOptions}
                            {...form.getInputProps('status')}
                        />
                        <DatePicker
                            locale="ru"
                            name="date"
                            label="Дата"
                            inputFormat="DD MMMM YYYY"
                            {...form.getInputProps('date')}
                        />
                    </Dialog.DialogContentContainer>
                )}
                <Dialog.DialogButtonsContainer>
                    <Dialog.Button type="submit">Добавть</Dialog.Button>
                    <Dialog.Button onClick={() => onHide()}>
                        Отмена
                    </Dialog.Button>
                </Dialog.DialogButtonsContainer>
            </form>
        </Dialog.DialogContainer>
    );
};

export default connector(AddToListDialog);
