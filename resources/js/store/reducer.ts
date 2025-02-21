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
    testLoaded: ERequestStatus;
    requestStatus: ERequestStatus;
    errorText: string;
    timeOfExecution: number;
};

const initialState: TState = {
    test: null,
    correct: 0,
    incorrect: 0,
    currentQuestion: 0,
    testLoaded: ERequestStatus.IDLE,
    requestStatus: ERequestStatus.IDLE,
    errorText: "",
    timeOfExecution: 0,
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
                if (state.currentQuestion <= state.test?.questions.length) {
                    state.currentQuestion = state.currentQuestion + 1;
                }
            }
        },
        tickTime: (state) => {
            state.timeOfExecution += 1;
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
            .addCase(fetchTest.rejected, (state, { payload }) => {
                state.errorText = payload || "Ошибка выполнения запроса";
                state.testLoaded = ERequestStatus.FAILED;
            })

            .addCase(sendAnswer.pending, (state) => {
                state.requestStatus = ERequestStatus.LOADING;
            })
            .addCase(sendAnswer.fulfilled, (state, { payload }) => {
                if (payload.result.is_correct == 1) {
                    state.correct += 1;
                } else {
                    state.incorrect += 1;
                }
                if (state.test) {
                    if (state.currentQuestion < state.test.questions.length) {
                        state.currentQuestion += 1;
                    }
                }
                state.requestStatus = ERequestStatus.SUCCEEDED;
            })
            .addCase(sendAnswer.rejected, (state, { payload }) => {
                state.errorText = payload || "Ошибка выполнения запроса";
                state.requestStatus = ERequestStatus.FAILED;
            })

            .addCase(sendResult.pending, (state) => {
                state.requestStatus = ERequestStatus.LOADING;
            })
            .addCase(sendResult.fulfilled, (state) => {
                if (state.test) {
                    if (
                        state.currentQuestion ===
                        state.test.questions.length - 1
                    ) {
                        state.currentQuestion = state.currentQuestion + 1;
                    }
                }
                state.requestStatus = ERequestStatus.SUCCEEDED;
            })
            .addCase(sendResult.rejected, (state, { payload }) => {
                state.errorText = payload || "Ошибка выполнения запроса";
                state.requestStatus = ERequestStatus.FAILED;
            });
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

type TSendAnswerResponse = {
    message: string;
    result: {
        student_id: number;
        question_id: number;
        answer_id: number;
        is_correct: number;
        updated_at: string;
        created_at: string;
        id: number;
    };
};

type TSendResultResponse = {
    message: string;
    result: {
        id: number;
        test_id: number;
        student_id: number;
        score: number;
    };
};

export interface TSendAnswerPayload {
    test_id: number;
    question_id: number;
    answer_id: number;
    last_answer: boolean;
}

export interface TSendResultPayload {
    test_id: number;
}

export const sendAnswer = createAsyncThunk<
    TSendAnswerResponse,
    TSendAnswerPayload,
    { rejectValue: string }
>("test/sendAnswer", async (payload, thunkAPI) => {
    try {
        const response: TSendAnswerResponse =
            await apiService.postAnswer(payload);
        return response;
    } catch (error) {
        return thunkAPI.rejectWithValue(
            error.message || "Ошибка при выпполнении запроса",
        );
    }
});

export const sendResult = createAsyncThunk<
    TSendResultResponse,
    TSendResultPayload,
    { rejectValue: string }
>("test/sendResult", async (payload, thunkAPI) => {
    try {
        const response: TSendResultResponse =
            await apiService.putAnswer(payload);
        return response;
    } catch (error) {
        return thunkAPI.rejectWithValue(
            error.message || "Ошибка при выпполнении запроса",
        );
    }
});

export default testSlice.reducer;

export const { setTest, incCorrect, incIncorrect, nextQuestion, tickTime } =
    testSlice.actions;
