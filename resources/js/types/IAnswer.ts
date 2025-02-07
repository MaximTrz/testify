interface IAnswer {
    id: number;
    question_id: number;
    answer_text: string;
    is_correct: number;
    created_at: string;
    updated_at: string;
}

export default IAnswer;
