import { useMemo } from "react";

import { useSelector, useDispatch } from "react-redux";
import { RootState, AppDispatch } from "../store";
import {
    nextQuestion,
    tickTime,
    sendAnswer,
    sendResult,
} from "../store/reducer";

import { TSendAnswerPayload, TSendResultPayload } from "../store/reducer";

const useTest = () => {
    const dispatch = useDispatch<AppDispatch>();

    const testItem = useSelector((state: RootState) => state.testSlice.test);

    const currentQuestion = useSelector(
        (state: RootState) => state.testSlice.currentQuestion,
    );

    const requestStatus = useSelector(
        (state: RootState) => state.testSlice.requestStatus,
    );

    const errorText = useSelector(
        (state: RootState) => state.testSlice.errorText,
    );

    const correct = useSelector((state: RootState) => state.testSlice.correct);

    const gradingCriteria = useSelector(
        (state: RootState) => state.testSlice.test?.grading_criteria,
    );

    const questions = useSelector(
        (state: RootState) => state.testSlice.test?.questions,
    );

    const testLoaded = useSelector(
        (state: RootState) => state.testSlice.testLoaded,
    );

    const allTIme = useSelector(
        (state: RootState) => state.testSlice.timeOfExecution,
    );

    const setNextQuestion = () => {
        if (testItem && currentQuestion < testItem.questions.length) {
            dispatch(nextQuestion());
        }
    };

    const nextTick = () => {
        dispatch(tickTime());
    };

    const sendStudendAnswer = (payload: TSendAnswerPayload) => {
        const result = dispatch(sendAnswer(payload));
        return result;
    };

    const sendTestResult = (payload: TSendResultPayload) => {
        const result = dispatch(sendResult(payload));
        return result;
    };

    return useMemo(
        () => ({
            testItem,
            currentQuestion,
            setNextQuestion,
            sendStudendAnswer,
            sendTestResult,
            requestStatus,
            gradingCriteria,
            correct,
            questions,
            testLoaded,
            errorText,
            nextTick,
            allTIme,
        }),
        [testItem, currentQuestion, requestStatus, testLoaded],
    );
};

export default useTest;
