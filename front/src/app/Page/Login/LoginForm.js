import React from 'react';
import styled from 'styled-components';
import { useNavigate, Navigate } from 'react-router-dom';

import { useAuth } from '../../Auth/AuthContext';

const FormContainer = styled.div`
    width: 400px;
`;

const Form = styled.form``;
const TextInput = styled.input``;
const LabelContainer = styled.div``;
const InputContainer = styled.div``;
const Button = styled.button``;

const LoginForm = () => {
    const { signin, user, isLoading } = useAuth();

    if (!isLoading && user) {
        return <Navigate to="/" />;
    }

    const onSubmit = (e) => {
        e.preventDefault();

        const form = new FormData(e.currentTarget);
        const login = form.get('login');
        const password = form.get('password');

        signin(login, password);
    };

    return (
        <FormContainer>
            <Form onSubmit={onSubmit}>
                <InputContainer>
                    <LabelContainer>Логин</LabelContainer>
                    <TextInput type="text" name="login" />
                </InputContainer>
                <InputContainer>
                    <LabelContainer>Пароль</LabelContainer>
                    <TextInput type="password" name="password" />
                </InputContainer>
                {!isLoading && <Button>Вход</Button>}
            </Form>
        </FormContainer>
    );
};

export default LoginForm;
