import * as React from "react";
import "./style.scss";
const Question: React.FC = () => {
    return (
        <div className="question">
            <div className="question__test-description">
                <div className="question__test-title">
                    {`Тест: Алгоритмы и способы их описания`}
                </div>
            </div>
            <div className="question__header">
                <div className="question__number">Вопрос 1</div>
                <div className="question__timer">06:00</div>
            </div>
            <div className="question__text">
                Вопрос вопрос вопрос вопрос вопрос вопрос вопрос вопрос..
            </div>
            <ul className="question__answer-list">
                <li className="question__answer-item">
                    <div className="question__answer-label">A</div>
                    <div className="question__answer-text">
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ ...
                    </div>
                </li>
                <li className="question__answer-item">
                    <div className="question__answer-label">B</div>
                    <div className="question__answer-text">
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ ...
                    </div>
                </li>
                <li className="question__answer-item">
                    <div className="question__answer-label">C</div>
                    <div className="question__answer-text">
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ ...
                    </div>
                </li>
                <li className="question__answer-item">
                    <div className="question__answer-label">D</div>
                    <div className="question__answer-text">
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ Ответ
                        Ответ Ответ ...
                    </div>
                </li>
            </ul>
            <div className="question__current-step">1 из 15</div>
            <div className="question__skip-wrapper">
                <button className="question__skip">Пропустить вопрос</button>
            </div>
        </div>
    );
};

export default Question;
