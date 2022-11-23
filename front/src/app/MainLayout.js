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
        font: 14px Roboto, Helvetica, Arial, sans-serif;
        padding: 0px;
        margin: 0px;
    }
`;

const MainContainer = styled.div`
    display: flex;
    margin-left: auto;
    margin-right: auto;
    width: 1000px;
    border: solid #000;
    border-width: 0px 1px;
    padding: 10px;
    margin-top: 20px;
`;

const SidebarLeft = styled.div`
    min-width: 250px;
    border-right: 1px solid #000;
`;

const RouteContent = styled.div`
    padding: 0px 20px;
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
        <MainContainer>
            <DialogsCollection />
            <SidebarLeft>
                <UserLists></UserLists>
            </SidebarLeft>
            <RouteContent>
                <Outlet />
            </RouteContent>
        </MainContainer>
    </RequireAuth>
);

export default Layout;
