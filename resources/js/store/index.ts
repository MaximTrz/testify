import { combineReducers, configureStore } from "@reduxjs/toolkit";
import testSlice from "./reducer";

const rootReducer = combineReducers({
    testSlice,
});

export const store = configureStore({
    reducer: rootReducer,
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;

export default store;
