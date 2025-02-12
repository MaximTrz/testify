import { useMemo } from "react";
import { useSelector, useDispatch } from "react-redux";
import { RootState } from "../store";
import { nextQuestion, setStarted } from "../store/reducer";

const useTest = () => {
    const dispatch = useDispatch();
    const testItem = useSelector((state: RootState) => state.testSlice.test);
    const currentQuestion = useSelector(
        (state: RootState) => state.testSlice.currentQuestion,
    );

    const setNextQuestion = () => {
        if (testItem && currentQuestion < testItem.questions.length - 1) {
            dispatch(nextQuestion());
        }
    };

    const startTest = () => {
        dispatch(setStarted(true));
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
        }),
        [testItem, currentQuestion],
    );
};

export default useTest;
