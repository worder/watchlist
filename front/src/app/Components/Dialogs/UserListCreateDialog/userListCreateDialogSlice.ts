import { createSlice } from '@reduxjs/toolkit';

export const getIsVisible = state => state.dialogs.userListCreate.isVisible;

const userListCreateDialogSlice = createSlice({
    name: 'dialogs_userListCreate',
    initialState: {
        isVisible: false,
    },
    reducers: {
        show(state) {
            state.isVisible = true;
        },
        hide(state) {
            state.isVisible = false;
        },
    },
});

export default userListCreateDialogSlice.reducer;

export const { show, hide } = userListCreateDialogSlice.actions;
