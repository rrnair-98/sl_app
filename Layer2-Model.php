<?php
include_once('Crud.php');
class StudentDetails // Holds the detail of student like its userID branch semester email name
{
    private $crud;
    private $studentID;
    private $branch;
    private $semester;
    private $email;
    private $name;
    function __construct($crud,$id)
    {
        $this->crud = $crud;
        $this->studentID = $id;
        $this->getStudentDetails();
    }
    private function getStudentDetails() // Pass the student id to get student's branch and semester from database returns Json Object
    {
        $columns = array('branch_id','branch_name','semester_id','semester_name');
        $result = $this->crud->getData($this->studentID,"student_sem_branch_mapping",$columns,"user_id");
        $this->branch = new Branch($this->crud,$result[0]['branch_id'],$result[0]['branch_name']);
        $this->semester = new Semester($this->crud,$result[0]['semester_id'],$result[0]['semester_name']);
        $columns = array('name','email');
        $result = $this->crud->getData($this->studentID,"user",$columns,"user_id");
        $this->name = $result[0]['name'];
        $this->email = $result[0]['email'];
    }
    function getStudentPersonalDetails()// Returns result set with name and email of student
    {
        return array("name"=>$this->name,"email"=>$this->email);
    }
    function getStudentName()//Returns name of Student
    {
        return $this->name;
    }
    function getStudentEmail()//Returns Student's Email
    {
        return $this->email;
    }
    function getStudentBranch()//Returns Branch object
    {
        return $this->branch;
    }
    function getStudentSemester()//Returns Semester object
    {
        return $this->semester;
    }
    function getStudentID()//Return's student's ID
    {
        return $this->studentID;
    }
}
class StudentSubject //Linking of subjects the student has enrolled in
{
    private $crud;
    private $studentID;
    private $subjects;
    function __construct($crud,$studentID)
    {
        $this->crud = $crud;
        $this->studentID = $studentID;
        $this->getStudentSubjects();
    }
    private function getStudentSubjects()//get all enrolled subjects of student
    {
        $columns = array('subject_id');
        $subjectIDs = $this->crud->getData($this->studentID,"enrolls",$columns,"user_id");
        $columns = array('subject_id','name');
        $result = array();
        for($i=0;$i<count($subjectIDs);$i++)
        {
            $result[] = $this->crud->getData($subjectIDs[$i]['subject_id'],"subject",$columns,"subject_id");
        }
        $this->subjects = array();
        for($i=0;$i<count($result);$i++)//loop to create a Subject object for each subject
        {
            $temp = $result[$i][0];
            $this->subjects[] = new Subject($this->crud,$temp['subject_id']);//add new Subject object to array of subjects
        }
    }
    function getSubjects()//returns array of subject objects
    {
        return $this->subjects;
    }
    function getSubjectIDs()//return array of subject IDs
    {
        $subID = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            $subID[] = $this->subjects[$i]->getSubjectID();
        }
        return $subID;
    }
    function getSubjectNames()//Return array of subject names
    {
        $subNames = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            $subNames[] = $this->subjects[$i]->getSubjectName();
        }
        return $subNames;
    }
}
class Subject //class for a single subject
{
    private $crud;
    private $subjectID;
    private $subjectName;
    private $semesterID;
    private $chapters;
    function __construct($crud,$subjectID)
    {
        $this->crud = $crud;
        $this->subjectID = $subjectID;
        $this->fetchSubjectDetails();
    }
    private function fetchSubjectDetails()//fetch all chapters and semester to which subject belongs
    {
        $columns = array('name','semester_id');
        $result = $this->crud->getData($this->subjectID,"subject",$columns,"subject_id");
        $this->subjectName = $result[0]['name'];
        $this->semesterID = $result[0]['semester_id'];
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->subjectID,"chapter",$columns,"subject_id");
        $this->chapters = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Chapter Objects
        {
            $this->chapters[] = new Chapter($this->crud,$result[$i]['chapter_id']);
        }
    }
    function getSubjectID()//Return SubjectID
    {
        return $this->subjectID;
    }
    function getSubjectName()//Return subject Name
    {
        return $this->subjectName;
    }
    function getSubjectSemesterID()//Return semesterID of subject
    {
        return $this->semesterID;
    }
    function getChapters()//Return array of Chapter Object
    {
        return $this->chapters;
    }
    function getChapterIDs()//Return array of chapter IDs
    {
        $chapterID = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapterID[] =  $this->chapters[$i]->getChapterID();
        }
        return $chapterID;
    }
    function getChapterNames()//Return array of chapter names
    {
        $chapternames = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapternames[] =  $this->chapters[$i]->getChapterName();
        }
        return $chapternames;
    }
}
class Chapter
{
    private $crud;
    private $chapterWeightage;
    private $chapterName;
    private $chapterID;
    private $questions;
    function __construct($crud,$chapterID)
    {
        $this->crud = $crud;
        $this->chapterID = $chapterID;
        $this->fetchChapterDetails();
    }
    private function fetchChapterDetails()//get chapter details like its name and weightage
    {
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->chapterID,"chapter",$columns,"chapter_id");
        $this->chapterName = $result[0]['name'];
        $this->chapterWeightage = $result[0]['weightage'];
        $this->fetchQuestions();
    }
    private function fetchQuestions()//fetch questions for the given chapter
    {
        $columns = array('question_id','level','statement','marks','probability','image_count','type','answer_ID');
        $result = $this->crud->getData($this->chapterID,"question",$columns,"chapter_id");
        $this->questions = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Question Objects
        {
            $this->questions[] = new Question($this->crud,$result[$i]['question_id']);
        }
    }
    function getChapterWeightage()//return chapter weightage
    {
        return $this->chapterWeightage;
    }
    function getChapterName()//return chapter name
    {
        return $this->chapterName;
    }
    function getChapterID()//return chapterID
    {
        return $this->chapterID;
    }
    function getQuestions()//return array of question objects
    {
        return $this->questions;
    }
    function getQuestionIDs()//return array of questionIDs
    {
        $questionID = array();
        for($i=0;$i<count($this->questions);$i++)
        {
            $question = $this->questions[$i];
            $questionID[] = $question->getQuestionID();
        }
        return $questionID;
    }
}
class Question
{
    private $crud;
    private $questionID;
    private $level;
    private $questionProbability;
    private $marks;
    private $statement;
    private $image_count;
    private $type;
    private $answer_id;
    private $test_count;
    private $options;
    function __construct($crud, $questionID)
    {
        $this->crud = $crud;
        $this->questionID = $questionID;
        $this->fetchQuestionDetails();
    }
    private function fetchQuestionDetails()
    {
        $columns = array('question_id', 'level', 'marks', 'probability', 'statement', 'image_count','test_count', 'type', 'answer_id');
        $result = $this->crud->getData($this->questionID, "question", $columns, "question_id");
        $this->level = $result[0]['level'];
        $this->questionProbability = $result[0]['probability'];
        $this->marks = $result[0]['marks'];
        $this->statement = $result[0]['statement'];
        $this->image_count = $result[0]['image_count'];
        $this->type = $result[0]['type'];
        $this->answer_id = $result[0]['answer_id'];
        $this->test_count = $result[0]['test_count'];
        $columns = array('option_id', 'statement', 'image_count');
        $result = $this->crud->getData($this->questionID, "options", $columns, "question_id");
        $this->options = array();
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]['option_id'] == $this->answer_id)
                continue;
            $this->options[] = new Option($this->crud, $result[$i]['option_id']);
        }
        $this->fetchOptions();
    }
    private function fetchOptions()
    {
        $columns = array('option_id', 'statement', 'image_count');
        $result = $this->crud->getData($this->questionID, "options", $columns, "question_id");
        $this->options = array();
        for($i=0;$i<count($result);$i++)//Insert into array of Option Objects
        {
            $this->options[] = new Option($this->crud,$result[$i]['option_id']);
        }
    }
    function getQuestionID()
    {
        return $this->questionID;
    }
    function getQuestionLevel()
    {
        return $this->level;
    }
    function getQuestionProbability()
    {
        return $this->questionProbability;
    }
    function getQuestionType()
    {
        return $this->type;
    }
    function getAnswerID()
    {
        return $this->answer_id;
    }
    function getQuestionImageCount()
    {
        return $this->image_count;
    }
    function getQuestionStatement()
    {
        return $this->statement;
    }
    function getQuestionMarks()
    {
        return $this->marks;
    }
    function getOptions()//Return array of option objects
    {
        return $this->options;
    }
    function getOptionIDs()// return array of optionIDs
    {
        $optionID = array();
        for ($i = 0; $i < count($this->options); $i++) {
            $option = $this->options[$i];
            $optionID[] = $option->getOptionID();
        }
        return $optionID;
    }
}
class Option //Class for an object
{
    private $crud;
    private $optionID;
    private $statement;
    private $image_count;
    function __construct($crud,$optionID)
    {
        $this->crud = $crud;
        $this->optionID = $optionID;
        $this->fetchOptionDetails();
    }
    private function fetchOptionDetails()
    {
        $columns = array('option_id','statement','image_count');
        $result = $this->crud->getData($this->optionID,"options",$columns,"option_id");
        $this->statement = $result[0]['statement'];
        $this->image_count = $result[0]['image_count'];
    }
    function getOptionID()
    {
        return $this->optionID;
    }
    function getOptionImageCount()
    {
        return $this->image_count;
    }
    function getOptionStatement()
    {
        return $this->statement;
    }
}
class TestAnswerSheet
{
    private $crud;
    private $test_id;
    private $answer_sheets;
    function __construct($crud,$test_id)
    {
        $this->crud = $crud;
        $this->test_id = $test_id;
        $this->fetchAnswerSheets();
    }
    private function fetchAnswerSheets()
    {
        $columns = array('answer_sheet_id');
        $result = $this->crud->getData($this->test_id, "answer_sheet", $columns, "test_id");
        $this->answer_sheets = array();
        for($i=0;$i<count($result);$i++)//Insert into array of answer_sheets
        {
            $this->answer_sheets[] = new AnswerSheet($this->crud,$result[$i]['answer_sheet_id']);
        }
    }
    function getTestID()//Returns test id
    {
        return $this->test_id;
    }
    function getAnswerSheets()//Returns an array of answer sheet objects
    {
        return $this->answer_sheets;
    }
    function getAnswerSheetIDs()// returns an array of IDs of answer sheets
    {
        $answer_sheetID = array();
        for ($i = 0; $i < count($this->answer_sheets); $i++) {
            $answer_sheet = $this->answer_sheets[$i];
            $answer_sheetID[] = $answer_sheet->getAnswerSheetID();
        }
        return $answer_sheetID;
    }
}
class AnswerSheet
{
    private $crud;
    private $question_id;
    private $selected_option_id;
    private $answer_sheet_id;
      function __construct($crud,$answer_sheet_id)
    {
        $this->crud = $crud;
        $this->answer_sheet_id = $answer_sheet_id;
        $this->fetchAnswerSheetDetails();
    }
    private function fetchAnswerSheetDetails()
    {
        $columns = array('answer_sheet_id','question_id','selected_option_id');
        $result = $this->crud->getData($this->answer_sheet_id,"answer_sheet",$columns,"answer_sheet_id");
        $this->question_id = $result[0]['question_id'];
        $this->selected_option_id = $result[0]['selected_option_id'];
    }
    function getQuestionID()
    {
        return $this->question_id;
    }
    function getSelectedOptionID()
    {
        return $this->selected_option_id;
    }
    function getAnswerSheetID()
    {
        return $this->answer_sheet_id;
    }
}
class Test {
    private $crud;
    private $testId;
    private $startDate;
    private $endDate;
    private $childOf;/*another test id reference */
    private $adminId;
    private $userId;
    private $testAnswerSheet;/*reference ot a test answer sheet*/
    public function  __construct($crud,$testId=NULL){
        $this->crud = $crud;
        $this->testId = $testId;
        if($testId != NULL){
            $this->fetchTestDetails();
        }
    }       
    final public function fetchTestDetails(){
        $columns = array("*");
        $result = $this->crud->getData($this->testId,"test",$columns,"test_id");
        $row = $result[0];
        $this->startDate = $row["start_date"]; 
        $this->endDate = $row["end_date"];
        $this->child_of = $row["child_of"];
        $this->adminId = $row["admin_id"];
        $this->userId = $row["user_id"];
        $this->testAnswerSheet = new TestAnswerSheet($this->crud,$this->testId);
    }

    /**
     * @param mixed $crud
     */
    public function setCrud($crud)
    {
        $this->crud = $crud;
    }

    /**
     * @param mixed $testId
     */
    public function setTestId($testId)
    {
        $this->testId = $testId;
    }

    /**
     * @return mixed
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return mixed
     */
    public function getChildOf()
    {
        return $this->childOf;
    }

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getTestAnswerSheet()
    {
        return $this->testAnswerSheet;
    }

    /**
     * @returns midex
     */
    public static function getTestIds($crud,$userId){
        $result = $crud->getData($userId,"test",array ("test_id"),"user_id");
        $tests = array();
        foreach($result as $item){
            $tests[]=$item["test_id"];
            //array_push($tests,$item["test_id"]);
        }
        return $tests;
    }
    
}
class Branch
{
    private $crud;
    private $branch_id;
    private $branch_name;
    function __construct($crud,$branch_id,$branch_name)
    {
        $this->crud = $crud;
        $this->branch_id = $branch_id;
        $this->branch_name = $branch_name;
    }
    function getBranchID()
    {
        return $this->branch_id;
    }
    function getBranchName()
    {
        return $this->branch_name;
    }
}
class Semester
{
    private $crud;
    private $semester_id;
    private $semester_name;
    function __construct($crud,$semester_id,$semester_name)
    {
        $this->crud = $crud;
        $this->semester_id = $semester_id;
        $this->semester_name = $semester_name;
    }
    function getSemesterID()
    {
        return $this->semester_id;
    }
    function getSemesterName()
    {
        return $this->semester_name;
    }
}
class StudentData implements JsonSerializable
{
    private $studentDetails;
    private $studentSubject;
    function __construct($crud,$studentDetails,$studentSubject)
    {
        $this->studentDetails = $studentDetails;
        $this->studentSubject = $studentSubject;
    }
    public function jsonSerialize()
    {
        $JSONsubjects = array();
        $subjects = $this->studentSubject->getSubjects();
        for($i=0;$i<count($subjects);$i++)
        {
            $JSONchapters = array();
            $chapters = $subjects[$i]->getChapters();
            for($j=0;$j<count($chapters);$j++)
            {
                $JSONchapters[] = array("chapter_id"=>$chapters[$i]->getChapterID(),"chapter_name"=>$chapters[$i]->getChapterName(),"chapter_weightage"=>$chapters[$i]->getChapterWeightage());
            }
            $JSONsubjects[] = array("subject_id"=>$subjects[$i]->getSubjectID(),"subject_name"=>$subjects[$i]->getSubjectName(),"subject_semester_id"=>$subjects[$i]->getSubjectSemesterID(),"chapters"=>$JSONchapters);
        }
        return ['user_id'=>$this->studentDetails->getStudentID(),'name'=>$this->studentDetails->getStudentName(),
            'email'=>$this->studentDetails->getStudentEmail(),
            'branch'=>array("branch_id"=>$this->studentDetails->getStudentBranch()->getBranchID(),"branch_name"=>$this->studentDetails->getStudentBranch()->getBranchName()),
            'semester'=>array("semester_id"=>$this->studentDetails->getStudentSemester()->getSemesterID(),"semester_name"=>$this->studentDetails->getStudentSemester()->getSemesterName()),
            'subjects'=>$JSONsubjects
        ];
    }
}
class QuestionData implements JsonSerializable //A custom implementation for json_encode to get question detail when question object is passed
{
    private $question;
    private $options;
    function __construct($crud,$question)
    {
        $this->question = $question;
    }
    public function jsonSerialize()
    {
        $JSONquestion_stmt = array();
        $question_statement = $this->question->getQuestionStatement(); //return question statement from question object
        $statementArray = json_decode($question_statement,true); //decode the question json into an assoc array
        $JSONoptions = array();
        $options = $this->question->getOptions();//get all the options for question
        for($i=0;$i<count($options);$i++) //loop to generate the options sub array with all options details
        {
            $option_statement = $options[$i]->getOptionStatement();
            $option_statementArray = json_decode($option_statement,true);//decode the json in object statement
            $JSONoptions[] = array("option_id"=>$options[$i]->getOptionID(),"options_url"=>$option_statementArray['options_url'],"options_text"=>$option_statementArray['options_text'],"sub_id"=>$option_statementArray['sub_id']);
        }
        return ["question_id"=>$this->question->getQuestionID(),"marks"=>$this->question->getQuestionMarks(),"type"=>$this->question->getQuestionType(),"major_stmt"=>$statementArray['major_stmt'],"question_stmt"=>$statementArray['question_stmt'],"options"=>$JSONoptions];//return the question detail in the required format
    }
}
?>