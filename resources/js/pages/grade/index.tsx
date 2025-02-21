import * as React from "react";
import { useMemo } from "react";

import timeFormatting from "../../utils/timeFormatting";

import useTest from "../../hooks/useTest";

import "./style.scss";

const Grade: React.FC = () => {
    const { gradingCriteria, correct, testItem, allTIme } = useTest();

    const studentGrade = useMemo(() => {
        let studentGrade = 2;

        if (Array.isArray(gradingCriteria) && gradingCriteria.length > 0) {
            const maxCorrect = Math.max(
                ...gradingCriteria.map((criteria) =>
                    Number(criteria.max_correct_answers),
                ),
            );

            if (correct >= maxCorrect) {
                return 5;
            }

            gradingCriteria.forEach((criteria) => {
                if (
                    correct >= Number(criteria.min_correct_answers) &&
                    correct <= Number(criteria.max_correct_answers)
                ) {
                    studentGrade = criteria.grade;
                }
            });

            return studentGrade;
        }

        return 0;
    }, [gradingCriteria, correct]);

    const gradeExplanation = useMemo(() => {
        switch (studentGrade) {
            case 1:
            case 2:
                return "Неудовлетворительно";
            case 3:
                return "Удовлетворительно";
            case 4:
                return "Хорошо";
            case 5:
                return "Отлично";
            default:
                return "";
        }
    }, [studentGrade]);

    return (
        <div className="grade">
            <div className="grade__title">
                Тест: Алгоритмы и способы их описания
            </div>
            <div className="grade__details">
                <div className="grade__results">
                    <div className="grade__result-text">Ваш результат</div>
                    <div className="grade__points">
                        {correct} верных ответов из {testItem?.questions.length}
                    </div>
                </div>

                <div className="grade__lead-time">
                    Время выполнения теста: {timeFormatting(allTIme)}
                </div>

                {studentGrade !== 0 ? (
                    <>
                        <div className="grade__text">
                            <span className="grade__score">
                                {" "}
                                {studentGrade}
                            </span>
                            <span className="grade__explanation">
                                {" "}
                                {gradeExplanation}{" "}
                            </span>
                        </div>
                        <div className="grade__teachers-mark">
                            Оценка зафиксирована преподавателем
                        </div>
                    </>
                ) : (
                    <div className="grade__text">
                        <span className="grade__explanation">
                            Критерии не заданы преподавателем
                        </span>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Grade;
