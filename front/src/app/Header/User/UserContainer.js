import React from 'react';
import { Link } from 'react-router-dom';
import styled from 'styled-components';
import { useGetInfoQuery } from '../../../api/user/userApi';
import { useAuth } from '../../Auth/AuthContext';

const UserInfoPlaceholder = styled.div`
    flex-basis: 30%;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
`;

const UserContainer = () => {
    const {  user : { email }, signout  } = useAuth();

    return (
        <UserInfoPlaceholder>
            <div>{email}</div>
            <a href="#" onClick={signout}>Выход</a>
        </UserInfoPlaceholder>
    );
};

export default UserContainer;
