import React, { useEffect, useState } from 'react';
import { connect } from 'react-redux';
import styled from 'styled-components';
import {
    TextInput,
    PasswordInput,
    InputWrapper,
    Button,
    Textarea,
} from '@mantine/core';
import { z } from 'zod';

import { getIsVisible, hide } from './userListCreateDialogSlice';
import { useForm, zodResolver } from '@mantine/form';
import { useCreateUserListMutation } from '../../../api/list/listApi';

interface Props {
    isVisible: boolean;
    onHide: () => void;
}

const DialogPlaceholder = styled.div<Partial<Props>>`
    display: ${(p) => (p.isVisible ? 'flex' : 'none')};
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
`;

const ModalOverlay = styled.div`
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.1;
    z-index: 1000;
`;

const DialogContainer = styled.div`
    border: 1px solid #000;
    background: #fff;
    width: 500px;
    z-index: 1001;
`;

const DialogHeader = styled.div`
    display: flex;
    border-bottom: 1px solid #000;
`;

const DialogTitle = styled.div`
    padding: 15px;
    height: 20px;
    width: 100%;
`;

const DialogCloseButton = styled.div`
    padding: 15px;
    cursor: pointer;
`;

const DialogContentContainer = styled.div`
    padding: 15px;
`;

const Form = styled.form``;

const FormRow = styled.div`
    & + & {
        padding-top: 20px;
    }
`;

const UserListCreateDialog = ({ isVisible, onHide }: Props) => {
    const [createList, result] = useCreateUserListMutation();
    const [errors, setErrors] = useState<{ title: string | null }>({
        title: null,
    });

    const inProgress = result.isLoading;

    const schema = z.object({
        title: z
            .string()
            .min(1, { message: 'Название не должно быть пустым' })
            .max(128, { message: 'Название не должно быть > 128 символов' }),
        desc: z.string().max(256),
    });

    const form = useForm({
        schema: zodResolver(schema),
        initialValues: {
            title: '',
            desc: '',
        },
    });

    const onListCreate = ({ title, desc }) => {
        createList({ desc, title });
    };

    useEffect(() => {
        if (result.isSuccess) {
            onHide();
        }
    }, [result.isSuccess]);

    useEffect(() => {
        if (isVisible) {
            form.setValues({
                title: '',
                desc: '',
            });
        }
    }, [isVisible]);

    useEffect(() => {
        if (result.isError) {
            if ('status' in result.error) {
                const { status, data } = result.error;
                setErrors({
                    ...errors,
                    title: 'Ошибка на сервере: ' + status + ' ' + data,
                });
            }
        } else {
            setErrors({
                title: null,
            });
        }
    }, [result.isError]);

    return (
        <DialogPlaceholder isVisible={isVisible}>
            <ModalOverlay />
            <DialogContainer>
                <DialogHeader>
                    <DialogTitle>Создание списка</DialogTitle>
                    <DialogCloseButton onClick={onHide}>X</DialogCloseButton>
                </DialogHeader>
                <DialogContentContainer>
                    <Form onSubmit={form.onSubmit(onListCreate)}>
                        <FormRow>
                            <TextInput
                                label="Название"
                                name="title"
                                error={errors.title}
                                {...form.getInputProps('title')}
                            />
                        </FormRow>
                        <FormRow>
                            <Textarea
                                label="Описание"
                                name="desc"
                                // error={false}
                                {...form.getInputProps('desc')}
                            />
                        </FormRow>
                        <FormRow>
                            <Button loading={inProgress} type="submit">
                                Создать
                            </Button>
                        </FormRow>
                    </Form>
                </DialogContentContainer>
            </DialogContainer>
        </DialogPlaceholder>
    );
};

export default connect(
    (state) => ({
        isVisible: getIsVisible(state),
    }),
    (dispatch) => ({
        onHide: () => dispatch(hide()),
    })
)(UserListCreateDialog);
