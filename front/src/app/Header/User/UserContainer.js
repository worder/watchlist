import React from 'react';
import { Link } from 'react-router-dom';
import styled from 'styled-components';
import { useGetInfoQuery } from '../../../api/user/userApi';
import { useAuth } from '../../Auth/AuthContext';

const UserContainer = () => {
    const {  user : { email }, signout  } = useAuth();

    return (
        <div>
            <div>{email}</div>
            <a href="#" onClick={signout}>Выход</a>
        </div>
    );
};

export default UserContainer;
