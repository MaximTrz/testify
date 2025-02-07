import * as React from "react";
import { useSelector } from "react-redux";
import { RootState } from "../../store";
import { Link } from "react-router-dom";

import "./style.scss";

const Description: React.FC = () => {
    const test = useSelector((state: RootState) => state.testSlice.test);

    return (
        <div className="description">
            {test ? (
                <>
                    <h1 className="description__title">Тест: {test.title}</h1>

                    <div className="description__time">
                        <strong className="description__time-title">
                            Срок выполнения:
                        </strong>
                        <div>
                            с {test.pivot.available_from} до{" "}
                            {test.pivot.available_until}
                        </div>
                    </div>

                    <div className="description__instruction">
                        <strong className="description__instruction-title">
                            Инструкция:{" "}
                        </strong>
                        <p className="description__instruction-block">
                            Количество вопросов: {test.questions.length}
                        </p>
                        <p className="description__instruction-block">
                            Исправить выбранный ответ невозможно.
                        </p>
                        <p className="description__instruction-block">
                            Тест проводится с ограничением по времени, при этом
                            для каждого вопроса отводится определённое
                            количество времени, которое зависит от его
                            сложности.
                        </p>
                    </div>

                    {test.grading_criteria.length > 0 ? (
                        <div className="description__criteria">
                            <h3 className="description__criteria-title">
                                Критерии оценки:
                            </h3>
                            <ul className="description__criteria-list">
                                {test.grading_criteria.map(
                                    (criteria, index) => (
                                        <li
                                            key={index}
                                            className="description__criteria-item"
                                        >
                                            {criteria.min_correct_answers}-
                                            {criteria.max_correct_answers}{" "}
                                            верных ответов - {criteria.grade}
                                        </li>
                                    ),
                                )}
                            </ul>
                        </div>
                    ) : (
                        <div className="description__criteria">
                            <h3 className="description__criteria-title">
                                Критерии оценки не заданы
                            </h3>
                        </div>
                    )}

                    <div className="description__start">
                        <Link
                            to={`/tests/${test.id}/questions`}
                            className="start"
                        >
                            <img
                                className="start__icon"
                                src="/img/start.svg"
                                alt="start"
                            />
                            Начать тестирование
                        </Link>
                    </div>
                </>
            ) : (
                <p>Загрузка теста...</p>
            )}
        </div>
    );
};

export default Description;
