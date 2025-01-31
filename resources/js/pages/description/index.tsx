import * as React from "react";
import "./style.scss";

interface Test {
  gradingCriteria: {
    min_correct_answers: number;
    max_correct_answers: number;
    grade: string;
  }[];
}

interface DescriptionProps {
  test: Test;
}

const Description: React.FC<DescriptionProps> = ({ test }) => {
  return (
    <div className="description">
      <h1 className="description__title">Тест: </h1>

      <p className="description__time">
        <strong className="description__time-title">Срок выполнения:</strong>
        с до
      </p>

      <div className="description__instruction">
        <strong className="description__instruction-title">Инструкция: </strong>
        <p className="description__instruction-block">Количество вопросов: </p>
        <p className="description__instruction-block">
          Исправить выбранный ответ невозможно.
        </p>
        <p className="description__instruction-block">
          Тест проводится с ограничением по времени, при этом для каждого
          вопроса отводится определённое количество времени, которое зависит от
          его сложности.
        </p>
      </div>

      {test.gradingCriteria.length > 0 ? (
        <div className="description__criteria">
          <h3 className="description__criteria-title">Критерии оценки:</h3>
          <ul className="description__criteria-list">
            {test.gradingCriteria.map((criteria, index) => (
              <li key={index} className="description__criteria-item">
                {criteria.min_correct_answers}-{criteria.max_correct_answers}{" "}
                верных ответов - {criteria.grade}
              </li>
            ))}
          </ul>
        </div>
      ) : (
        <div className="description__criteria">
          <h3 className="description__criteria-title">Критерии оценки не заданы</h3>
        </div>
      )}

      <div className="description__start">
        <a href="#" className="start">
          <img className="start__icon" src="/img/start.svg" alt="start" />
          Начать тестирование
        </a>
      </div>
    </div>
  );
};

export default Description;