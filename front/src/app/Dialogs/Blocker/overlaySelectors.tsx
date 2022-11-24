import { createSlice } from "@reduxjs/toolkit";
import { RootState } from "../../../store/store";

export const isVisible = (state: RootState) => {
    return Object.values(state.dialogs).some(dialogState => dialogState.isVisible);
}