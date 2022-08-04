import React from 'react';
import styled from 'styled-components';
import { connect } from 'react-redux';

const LogoPlaceholder = styled.div`
    flex-basis: 30%;
`;

const LogoContainer = () => <LogoPlaceholder>Watchlist (dev)</LogoPlaceholder>

export default LogoContainer;