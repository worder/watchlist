import React from 'react';
import styled from 'styled-components';
import { useGetInfoQuery } from '../../../api/user/userApi';

const UserContainer = () => {

    const info = useGetInfoQuery();
    console.log(info);

    return <div>user_info_placeholder</div>
}

export default UserContainer;