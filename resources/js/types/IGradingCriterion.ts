interface IGradingCriterion {
  id: number;
  test_id: number;
  min_correct_answers: number;
  max_correct_answers: number;
  grade: number;
}

export default IGradingCriterion;