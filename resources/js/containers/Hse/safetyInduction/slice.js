import { createSlice } from '@reduxjs/toolkit'

const initialState = {
    isInductionPageLoaded: false,
    uiAction: '',
    modal: {
        activeStep: 0
    }
}

export const safetySlice = createSlice({
    name: 'safetyInduction',
    initialState,
    reducers: {
        loadPage: (state) => {
            state.isInductionPageLoaded = true;
        },
        setUiAction: (state, action) => {
            state.uiAction = action.payload
        },
        setModalActiveStep: (state, action) => {
            state.modal.activeStep = action.payload;
        }

    },
})

export const {
    loadPage,
    setUiAction,
    setModalActiveStep
} = safetySlice.actions
export default safetySlice.reducer