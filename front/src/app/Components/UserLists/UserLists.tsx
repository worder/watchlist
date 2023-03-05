import * as React from 'react';
import styled from 'styled-components';
import { connect } from 'react-redux';

import { useAuth } from '../Auth/AuthContext';
import { useGetUserListsQuery } from '../../../api/list/listApi';
import { UserListsResult } from '../../../api/list/listsTypes';

import { show } from '../Dialogs/UserListCreateDialog/userListCreateDialogSlice';
import { NavLink } from 'react-router-dom';

const UserListsContainer = styled.div`
`;

const UserListAddButtonContainer = styled.div``;

const UserListAddButton = styled.button``;

const UserListLink = styled(NavLink)`
    display: block;
    border: 0px;
`;

const UserLists = ({ onShowCreateListDialog }) => {
    const auth = useAuth();
    const skipListsFetch = !auth?.user;

    let ready = false;
    var lists: UserListsResult = [];

    if (auth?.user) {
        const userLists = useGetUserListsQuery(auth?.user.id, {
            skip: skipListsFetch,
        });

        if (userLists.isSuccess && userLists.data) {
            lists = userLists.data;
            ready = true;
        }
    }

    return (
        <UserListsContainer>
            {(ready && (
                <div>
                    <b>user lists:</b>
                    {lists.map((l) => (
                        <UserListLink to={'/list/' + l.listId} key={l.listId}>{l.title}</UserListLink>
                    ))}
                </div>
            )) || <div>Loading...</div>}
            <UserListAddButtonContainer>
                <UserListAddButton onClick={onShowCreateListDialog}>Создать список</UserListAddButton>
            </UserListAddButtonContainer>
        </UserListsContainer>
    );
};

export default connect(null, (dispatch) => ({
    onShowCreateListDialog: () => dispatch(show()),
}))(UserLists);
