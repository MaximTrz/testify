import IAnswer from "./IAnswer";

interface IQuestion {
    id: number;
    test_id: number;
    question_text: string;
    question_type: "single" | "multiple";
    time_limit: number;
    answers: IAnswer[];
}

export default IQuestion;
