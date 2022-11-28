import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { string } from 'zod';
import { RootState } from '../../../store/store';

interface State {
    isVisible: boolean;
    api: string | null;
    mediaId: number | null;
}

const initialState = {
    isVisible: false,
    api: null,
    mediaId: null,
} as State;

export const getIsVisible = (state: RootState) => state.dialogs.addToList.isVisible;

const slice = createSlice({
    name: 'dialog_addTolist',
    initialState,
    reducers: {
        show(state, action: PayloadAction<{ api: string; mediaId: number }>) {
            state.isVisible = true;
            state.api = action.payload.api;
            state.mediaId = action.payload.mediaId;
        },
        hide() {
            return initialState;
        },
    },
});

export const { hide, show } = slice.actions;
export default slice.reducer;
