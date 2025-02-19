import * as React from "react";
import { useEffect, useMemo, useState, useCallback } from "react";
import Loader from "../../components/loader";
import useTest from "../../hooks/useTest";
import shuffleArray from "../../utils/shuffleArray";
import timeFormatting from "../../utils/timeFormatting";
import "./style.scss";
import { ERequestStatus } from "../../types/ERequestStatus";

const Question: React.FC = () => {
    const {
        testItem,
        currentQuestion,
        setNextQuestion,
        sendStudendAnswer,
        sendTestResult,
        requestStatus,
        errorText,
        nextTick,
    } = useTest();

    const [isAnswered, setIsAnswered] = useState(false);
    const [timeLeft, setTimeLeft] = useState(60);

    const question = testItem?.questions?.[currentQuestion];

    useEffect(() => {
        setTimeLeft(question?.time_limit ?? 60);
        setIsAnswered(false);
    }, [question]);

    const sendAnwser = useCallback(
        (payload) => {
            sendStudendAnswer({
                test_id: payload.test_id,
                question_id: payload.question_id,
                answer_id: payload.answer_id,
                last_answer:
                    currentQuestion === (testItem?.questions?.length ?? 0) - 1,
            });
            setIsAnswered(true);
        },
        [sendStudendAnswer],
    );

    const skipAnswer = useCallback(() => {
        if (testItem) {
            if (currentQuestion === testItem?.questions?.length - 1) {
                sendTestResult({ test_id: testItem.id });
            } else {
                setNextQuestion();
            }
        }
    }, [testItem, currentQuestion]);

    useEffect(() => {
        if (
            !question ||
            timeLeft <= 0 ||
            requestStatus === ERequestStatus.FAILED
        ) {
            return;
        }

        const interval = setInterval(() => {
            setTimeLeft((prevTime) => prevTime - 1);
            nextTick();
        }, 1000);

        return () => clearInterval(interval);
    }, [timeLeft, question, requestStatus, currentQuestion]);

    useEffect(() => {
        if (timeLeft === 0) {
            setNextQuestion();
        }
    }, [timeLeft, setNextQuestion]);

    const answers = useMemo(() => {
        if (!question) return [];
        return shuffleArray(question.answers);
    }, [question]);

    if (requestStatus == ERequestStatus.FAILED) {
        return <div> {errorText} </div>;
    }

    if (requestStatus === ERequestStatus.LOADING || isAnswered) {
        return <Loader />;
    }

    if (!testItem || !question) {
        return <div>Тест не загружен</div>;
    }

    return (
        <div className="question">
            <div className="question__test-description">
                <div className="question__test-title">{testItem?.title}</div>
            </div>
            <div className="question__header">
                <div className="question__number">
                    Вопрос {currentQuestion + 1}
                </div>
                <div className="question__timer">
                    {timeFormatting(timeLeft)}
                </div>
            </div>
            <div className="question__text">{question.question_text}</div>
            <ul className="question__answer-list">
                {answers.map((answer, index) => (
                    <li
                        key={`${answer.id}-${index}`}
                        className={`question__answer-item ${isAnswered ? "question__answer-item--disabled" : ""}`}
                        onClick={() => {
                            if (isAnswered) return;
                            sendAnwser({
                                test_id: testItem.id,
                                question_id: question.id,
                                answer_id: answer.id,
                            });
                        }}
                    >
                        <div className="question__answer-label">
                            {String.fromCharCode(65 + index)}
                        </div>
                        <div className="question__answer-text">
                            {answer.answer_text}
                        </div>
                    </li>
                ))}
            </ul>
            <div className="question__current-step">
                {currentQuestion + 1} из {testItem.questions.length}
            </div>
            <div className="question__skip-wrapper">
                <button className="question__skip" onClick={skipAnswer}>
                    Пропустить вопрос
                </button>
            </div>
        </div>
    );
};

export default Question;
