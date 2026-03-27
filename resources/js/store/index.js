import { configureStore } from '@reduxjs/toolkit'
import safetySliceReducer from '../containers/Hse/safetyInduction/slice'
export const store = configureStore({
  reducer: {
    safetySlice: safetySliceReducer
  },
  devTools: process.env.NODE_ENV !== 'production'
})