import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { RootState } from '../../../store/store';

interface State {
    isVisible: boolean;
    api: string | null;
    mediaId: number | null;
    type: string | null;
}

const initialState = {
    isVisible: false,
    api: null,
    mediaId: null,
    type: null,
} as State;

export const getIsVisible = (state: RootState) =>
    state.dialogs.addToList.isVisible;

export const getDetails = (state: RootState) => {
    const { api, mediaId, type } = state.dialogs.addToList;
    return { api, mediaId, type };
};

const slice = createSlice({
    name: 'dialog_addTolist',
    initialState,
    reducers: {
        show(
            state,
            action: PayloadAction<{
                api: string;
                mediaId: number;
                type: string;
            }>
        ) {
            const { mediaId, api, type } = action.payload;
            return {
                isVisible: true,
                api,
                type,
                mediaId,
            };
        },
        hide() {
            return initialState;
        },
    },
});

export const { hide, show } = slice.actions;
export default slice.reducer;
