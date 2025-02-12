import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import ITest from "../types/ITest";

import { ERequestStatus } from "../types/ERequestStatus";
import shuffleArray from "../utils/shuffleArray";

import ApiService from "../apiService";
const apiService = new ApiService();

export type TState = {
    test: ITest | null;
    correct: number;
    incorrect: number;
    currentQuestion: number;
    started: boolean;
    testLoaded: ERequestStatus;
};

const initialState: TState = {
    test: null,
    correct: 0,
    incorrect: 0,
    currentQuestion: 0,
    started: false,
    testLoaded: ERequestStatus.IDLE,
};

const testSlice = createSlice({
    name: "test",
    initialState,
    reducers: {
        setTest: (state, { payload }: { payload: ITest }) => {
            state.test = payload;
        },
        incCorrect: (state) => {
            state.correct += 1;
        },
        incIncorrect: (state) => {
            state.incorrect += 1;
        },
        nextQuestion: (state) => {
            if (state.test) {
                if (state.currentQuestion < state.test?.questions.length) {
                    state.currentQuestion = state.currentQuestion + 1;
                }
            }
        },
        resetTest: (state) => {
            state.currentQuestion = 0;
            state.correct = 0;
            state.incorrect = 0;
            state.started = false;
        },
        setStarted: (state, { payload }: { payload: boolean }) => {
            state.started = payload;
        },
    },
    extraReducers: (builder) => {
        builder
            .addCase(fetchTest.pending, (state) => {
                state.testLoaded = ERequestStatus.LOADING;
            })
            .addCase(fetchTest.fulfilled, (state, { payload }) => {
                state.testLoaded = ERequestStatus.SUCCEEDED;
                payload.questions = shuffleArray(payload.questions);
                state.test = payload;
            })
            .addCase(fetchTest.rejected, () => {});
    },
});

export const fetchTest = createAsyncThunk<
    ITest,
    number,
    { rejectValue: string }
>("test/fetchTest", async (id, thunkAPI) => {
    try {
        const serverTestData: ITest = await apiService.getTest(id);
        return serverTestData;
    } catch (error) {
        return thunkAPI.rejectWithValue(error.message);
    }
});

export default testSlice.reducer;

export const { setTest, incCorrect, incIncorrect, nextQuestion, setStarted } =
    testSlice.actions;
