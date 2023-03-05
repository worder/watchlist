import React from 'react';
import AddToListDialog from './AddToListDialog/AddToListDialog';
import Overlay from './Blocker/Overlay';

import UserListCreateDialog from './UserListCreateDialog/UserListCreateDialog';

const DialogsCollection = () => (
    <>
        <Overlay />
        <UserListCreateDialog />
        <AddToListDialog />
    </>
);

export default DialogsCollection;
