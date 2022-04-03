import React from 'react';
import { Helmet } from 'react-helmet';
import HeadContainer from '../../Header/HeadContainer';
import LogoContainer from '../../Header/Logo/LogoContainer';
import SearchTop from '../../Header/Search/SearchTopContainer';
import UserContainer from '../../Header/User/UserContainer';

const IndexPage = () => (
    <>
        <Helmet>
            <title>Index</title>
        </Helmet>
        <HeadContainer>
            <LogoContainer />
            <SearchTop />
            <UserContainer />
        </HeadContainer>
    </>
);

export default IndexPage;
