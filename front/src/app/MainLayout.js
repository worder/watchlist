import React from 'react';
import { hot } from 'react-hot-loader/root';
import styled from 'styled-components';
import { Outlet } from 'react-router-dom';

import HeadContainer from './Header/HeadContainer';
import LogoContainer from './Header/Logo/LogoContainer';
import UserContainer from './Header/User/UserContainer';
import SearchTop from './Header/Search/SearchTopContainer';

import RequireAuth from './Auth/RequireAuth';

const ContentContainer = styled.div`
    margin-left: auto;
    margin-right: auto;
    width: 1000px;
    border: 1px solid #000;
    padding: 10px;
`;

const Layout = () => (
    <RequireAuth>
        <ContentContainer>
            <HeadContainer>
                <LogoContainer />
                <SearchTop />
                <UserContainer />
            </HeadContainer>
            <Outlet />
        </ContentContainer>
    </RequireAuth>
);

export default hot(Layout);
