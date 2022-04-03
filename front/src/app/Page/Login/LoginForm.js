import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import { useNavigate, Navigate } from 'react-router-dom';
import { TextInput, PasswordInput, InputWrapper, Button } from '@mantine/core';
import { useForm, zodResolver } from '@mantine/form';
import { z } from 'zod';

import { useAuth } from '../../Auth/AuthContext';

const FormContainer = styled.div`
    width: 400px;
    background: #eee;
    padding: 15px;
    border-radius: 5px;
`;

const Form = styled.form``;
// const TextInput = styled.input``;
// const LabelContainer = styled.div``;
// const InputContainer = styled.div``;
// const Button = styled.button``;

const LoginForm = () => {
    const { signin, user, isLoading, isSigninError, signinError } = useAuth();

    const schema = z.object({
        login: z.string().email({ message: 'Неверный email' }),
        password: z
            .string()
            .min(4, { message: 'Пароль должен быть больше 4 символов' }),
    });

    const form = useForm({
        schema: zodResolver(schema),
        initialValues: {
            login: '',
            password: '',
        },
    });

    const [errors, setErrors] = useState({});

    const loginError = (message) => {
        setErrors({ ...errors, login: message });
    };
    const resetErrors = () => {
        setErrors({});
    };

    console.log('isSigninError', isSigninError);
    console.log('signinError', signinError);

    useEffect(() => {
        if (isSigninError) {
            const error = signinError.data?.error;
            switch (error) {
                case 'INVALID_CREDENTIALS':
                    loginError('неверный пароль');
                    break;
                case 'USER_NOT_FOUND':
                    loginError('Пользователь не существует');
                    break;
            }
        } else {
            resetErrors();
        }
    }, [signinError, isSigninError]);

    if (!isLoading && user) {
        return <Navigate to="/" />;
    }

    const onSubmit = ({login, password}) => {
        resetErrors();
        signin(login, password);
    };

    return (
        <FormContainer>
            <Form onSubmit={form.onSubmit(onSubmit)}>
                <TextInput
                    label="Логин"
                    name="login"
                    error={errors.login}
                    {...form.getInputProps('login')}
                />
                <PasswordInput
                    label="Пароль"
                    style={{ marginTop: '15px' }}
                    {...form.getInputProps('password')}
                />
                <Button
                    type="submit"
                    loading={isLoading}
                    style={{ marginTop: '15px' }}
                >
                    Вход
                </Button>
            </Form>
        </FormContainer>
    );
};

export default LoginForm;
