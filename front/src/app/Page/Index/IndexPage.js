import React from 'react';
import HeadContainer from '../../Header/HeadContainer';
import LogoContainer from '../../Header/Logo/LogoContainer';
import SearchTop from '../../Header/Search/SearchTopContainer';
import UserContainer from '../../Header/User/UserContainer';

const IndexPage = () => (
    <HeadContainer>
        <LogoContainer />
        <SearchTop />
        <UserContainer />
    </HeadContainer>
);

export default IndexPage;
