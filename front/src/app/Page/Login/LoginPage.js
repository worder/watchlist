import React from 'react';
import { Helmet } from 'react-helmet';
import styled, { createGlobalStyle } from 'styled-components';

import LoginForm from './LoginForm';

const GlobalStyle = createGlobalStyle`
    html {
        margin: 0px;
        padding: 0px;
        height: 100%
    }
    body, #app-root {
        margin: 0px;
        padding: 0px;
        height: 100%;
    }
`;

const PageContent = styled.div`
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100%;
`;

const LoginPage = () => {
    return (
        <PageContent>
            <GlobalStyle />
            <Helmet>
                <title>Sign in</title>
            </Helmet>
            <LoginForm />
        </PageContent>
    );
};

export default LoginPage;
