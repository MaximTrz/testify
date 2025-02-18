import { useMemo } from "react";

import { useSelector, useDispatch } from "react-redux";
import { RootState } from "../store";
import { nextQuestion, setStarted } from "../store/reducer";
import { sendAnswer } from "../store/reducer";
import { AppDispatch } from "../store";

import { TSendAnswerPayload } from "../store/reducer";

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

    const setNextQuestion = () => {
        if (testItem && currentQuestion < testItem.questions.length) {
            dispatch(nextQuestion());
        }
    };

    const startTest = () => {
        dispatch(setStarted(true));
    };

    const sendStudendAnswer = (payload: TSendAnswerPayload) => {
        const result = dispatch(sendAnswer(payload));
        return result;
    };

    const getTestStarted = useSelector(
        (state: RootState) => state.testSlice.started,
    );

    return useMemo(
        () => ({
            testItem,
            currentQuestion,
            setNextQuestion,
            setStarted,
            startTest,
            getTestStarted,
            sendStudendAnswer,
            requestStatus,
            gradingCriteria,
            correct,
            questions,
            testLoaded,
            errorText,
        }),
        [testItem, currentQuestion, requestStatus, testLoaded],
    );
};

export default useTest;
