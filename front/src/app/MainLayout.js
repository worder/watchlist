import React from 'react';
import styled, { createGlobalStyle } from 'styled-components';
import { Outlet } from 'react-router-dom';
import { Helmet } from 'react-helmet';

import HeadContainer from './Header/HeadContainer';
import LogoContainer from './Header/Logo/LogoContainer';
import UserContainer from './Header/User/UserContainer';
import SearchTop from './Header/Search/SearchTopContainer';
import UserLists from './UserLists/UserLists';

import RequireAuth from './Auth/RequireAuth';
import DialogsCollection from './Dialogs/DialogsCollection';

const GlobalStyle = createGlobalStyle`
    body, html {
        padding: 0px;
        margin: 0px;
    }
`;

const ContentContainer = styled.div`
    margin-left: auto;
    margin-right: auto;
    width: 1000px;
    border: 1px solid #000;
    padding: 10px;
`;

const Layout = () => (
    <RequireAuth>
        <Helmet>
            <title>Watchlist | main page</title>
        </Helmet>
        <GlobalStyle />
        <HeadContainer>
            <LogoContainer />
            <SearchTop />
            <UserContainer />
        </HeadContainer>
        <ContentContainer>
            <DialogsCollection />
            <UserLists></UserLists>
            <Outlet />
        </ContentContainer>
    </RequireAuth>
);

export default Layout;
