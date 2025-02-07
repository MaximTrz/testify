import IGradingCriterion from "./IGradingCriterion";
import IQuestion from "./IQuestion";

interface ITest {
  id: number;
  title: string;
  time_limit: number;
  teacher_id: number;
  pivot: {
    group_id: number;
    test_id: number;
    available_from: string;
    available_until: string;
  };
  grading_criteria: IGradingCriterion[];
  questions: IQuestion[];
}

export default ITest;