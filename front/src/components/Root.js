import React from "react";
import { hot } from "react-hot-loader/root";

import ContentContainer from "./ContentContainer";
import HeadContainer from "./Header/HeadContainer";
import SearchTop from "./Header/Search/SearchTopContainer";
import LogoContainer from "./Header/Logo/LogoContainer";
import UserContainer from "./Header/User/UserContainer";

const Root = () => (
  <ContentContainer>
    <HeadContainer>
        <LogoContainer />
        <SearchTop />
        <UserContainer />
    </HeadContainer>
  </ContentContainer>
);

export default hot(Root);
