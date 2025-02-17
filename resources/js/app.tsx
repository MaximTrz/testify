import React, { useEffect } from "react";
import { useParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { AppDispatch, RootState } from "./store";
import { fetchTest } from "./store/reducer";
import { ERequestStatus } from "./types/ERequestStatus";
import Question from "./pages/question";
import Grade from "./pages/grade";

const App: React.FC = () => {
    const dispatch = useDispatch<AppDispatch>();
    const { testId } = useParams<{ testId: string }>();
    const testLoaded = useSelector(
        (state: RootState) => state.testSlice.testLoaded,
    );
    const questions = useSelector(
        (state: RootState) => state.testSlice.test?.questions,
    );

    const curentQuestion = useSelector(
        (state: RootState) => state.testSlice.currentQuestion,
    );

    useEffect(() => {
        if (testId) {
            dispatch(fetchTest(Number(testId)));
        }
    }, [dispatch, testId]);

    if (testLoaded == ERequestStatus.LOADING) {
        return <div>Загрузка теста...</div>;
    }

    if (testLoaded == ERequestStatus.FAILED) {
        return <div>Ошибка загрузки теста</div>;
    }

    if (curentQuestion == (questions?.length ?? 0)) {
        return <Grade />;
    }

    return <Question />;
};

export default App;
