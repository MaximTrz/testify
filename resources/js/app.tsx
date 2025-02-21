import React, { useEffect } from "react";
import { useParams } from "react-router-dom";
import { useDispatch } from "react-redux";
import { AppDispatch } from "./store";
import { fetchTest } from "./store/reducer";
import { ERequestStatus } from "./types/ERequestStatus";
import Question from "./pages/question";
import useTest from "./hooks/useTest";
import Grade from "./pages/grade";
import Loader from "./components/loader";

const App: React.FC = () => {
    const dispatch = useDispatch<AppDispatch>();
    const { testId } = useParams<{ testId: string }>();

    const { testLoaded, questions, currentQuestion } = useTest();

    useEffect(() => {
        if (testId) {
            dispatch(fetchTest(Number(testId)));
        }
    }, [dispatch, testId]);

    if (testLoaded == ERequestStatus.LOADING) {
        return <Loader />;
    }

    if (testLoaded == ERequestStatus.FAILED) {
        return <div>Ошибка загрузки теста</div>;
    }

    if (questions?.length ?? 0) {
        if (currentQuestion == (questions?.length ?? 0)) {
            return <Grade />;
        }
    }

    return <Question />;
};

export default App;
