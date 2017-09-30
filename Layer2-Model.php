<?php

include_once('Crud.php');

class StudentDetails
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
    
    
    
    function getStudentPersonalDetails()
    {
        return array("name"=>$this->name,"email"=>$this->email);
    }
    
    function getStudentName()
    {
        return $this->name;
    }
    
    function getStudentEmail()
    {
        return $this->email;
    }
    
    function getStudentBranch()//Return Result Set with Branch ID and name
    {
        return $this->branch;
        
    }
    
    function getStudentSemester()//Return Result Set with Semester ID and name
    {
        return $this->semester;
    }
    
        
    function getStudentID()
    {
        return $this->studentID;
    }
    
    
}

class StudentSubject
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
    
    private function getStudentSubjects()
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
        for($i=0;$i<count($result);$i++)
        {
                $temp = $result[$i][0];
           
                $this->subjects[] = new Subject($this->crud,$temp['subject_id']);
           
        }
        
    }
    
    function getSubjects()
    {
        return $this->subjects;
        
    }
    
    function getSubjectIDs()
    {
        $subID = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            
            $subID[] = $this->subjects[$i]->getSubjectID();
            
        }
        return $subID;
    }
    
    function getSubjectNames()
    {
        $subNames = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            
            $subNames[] = $this->subjects[$i]->getSubjectName();
            
        }
        return $subNames;
        
    }
    
}

class Subject
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
    
    private function fetchSubjectDetails()
    {
        $columns = array('name','semester_id');
        $result = $this->crud->getData($this->subjectID,"subject",$columns,"subject_id");
        $this->subjectName = $result[0]['name'];
        $this->semesterID = $result[0]['semester_id'];
        
        
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->subjectID,"chapter",$columns,"subject_id");
        $this->chapters = array();
        for($i=0;$i<count($result);$i++)
        {
                
                $this->chapters[] = new Chapter($this->crud,$result[$i]['chapter_id']);
        }
        
    }
    
    function getSubjectID()
    {
        return $this->subjectID;    
    }
    
    function getSubjectName()
    {
        return $this->subjectName;
    }
    
    function getSubjectSemesterID()
    {
        return $this->semesterID;
    }
    
    function getChapters()
    {
        return $this->chapters;
    }
    
    function getChapterIDs()
    {
        $chapterID = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapterID[] =  $this->chapters[i]->getChapterID();
            
        }
        return $chapterID;
    }
    
     function getChapterNames()
    {
        $chapternames = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapternames[] =  $this->chapters[i]->getChapterName();
            
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
    
    function __construct($crud,$chapterID)
    {
        $this->crud = $crud;
        $this->chapterID = $chapterID;
        $this->fetchChapterDetails();
        
    }
    
    private function fetchChapterDetails()
    {
        $columns = array('chapter_id','name','weightage');
        $result = $this->crud->getData($this->chapterID,"chapter",$columns,"chapter_id");
        $this->chapterName = $result[0]['name'];
        $this->chapterWeightage = $result[0]['weightage'];
        
        
    }
    function getChapterWeightage()
    {
        return $this->chapterWeightage;
    }
    
    
    function getChapterName()
    {
        return $this->chapterName;
    }
    
     function getChapterID()
    {
        return $this->chapterID;
    }

}


class ChapterQuestion
{
    private $crud;
    private $chapterID;
    private $questions;
    
    function __construct($crud,$chapter)
    {
        $this->crud = $crud;
        $this->chapterID = $chapter->getChapterID();
        $this->fetchQuestions();
    }
    
    private function fetchQuestions()
    {
        $columns = array('question_id','level','statement','marks','probability','image_count','type','answer_ID');
        $this->questions = $this->crud->getData($this->chapterID,"question",$columns,"chapter_id");
                
    }
    
    function getQuestions()
    {
        return $this->questions;
    }
    
    function getQuestionIDs()
    {
        $questionID = array();
        for($i=0;$i<count($this->questions);$i++)
        {
            $question = $this->questions[$i];
            $questionID[] = $question['question_id'];
            
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
        
    
    function __construct($crud,$questionID)
    {
        $this->crud = $crud;
        $this->questionID = $questionID;
        $this->fetchQuestionDetails();
    }
    
    private function fetchQuestionDetails()
    {
        $columns = array('question_id','level','marks','probability','statement','image_count','type','answer_id');
        $result = $this->crud->getData($this->questionID,"question",$columns,"question_id");
        
        $this->level = $result[0]['level'];
        $this->questionProbability = $result[0]['probability'];
        $this->marks = $result[0]['marks'];
        $this->statement = $result[0]['statement'];
        $this->image_count = $result[0]['image_count'];
        $this->type = $result[0]['type'];
        $this->answer_id = $result[0]['answer_id'];
        
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
    
    
    
}

class QuestionOption
{
    
    private $crud;
    private $questionID;
    private $optionss;
    
    function __construct($crud,$question)
    {
        $this->crud = $crud;
        $this->questionID = $question->getQuestionID();
        $this->fetchOptions();
    }
    
    private function fetchOptions()
    {
        $columns = array('option_id','statement','image_count');
        $this->options = $this->crud->getData($this->questionID,"options",$columns,"question_id");
                
    }
    
    function getOptions()
    {
        return $this->options;
    }
    
    function getOptionIDs()
    {
        $optionID = array();
        for($i=0;$i<count($this->options);$i++)
        {
            $option = $this->options[$i];
            $optionID[] = $option['option_id'];
            
        }
        return $optionID;
    }
    
    
}


class Option
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
    private $subjects;
    private $chapters;
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

/*
$crud = new Crud("localhost","root","","quizapp");

$sd = new StudentDetails($crud,1);

$ss = new StudentSubject($crud,1);


*/

//$c = $s[0]->getChapters();

//echo $c[1]->getChapterName();


/*$ss = new StudentSubject($crud,$sd);

$subjectID = $ss->getSubjectIDs();

$s = new Subject($crud,$subjectID[0]);

$subchapter = new SubjectChapter($crud,$s);

$chapterid = $subchapter->getChapterIDs();

$chap = new Chapter($crud,$chapterid[0]);

$cq = new ChapterQuestion($crud,$chap);
$qIDs = $cq->getQuestionIDs();
$q = new Question($crud,$qIDs[0]);

$qo = new QuestionOption($crud,$q);

$oIDs = $qo->getOptionIDs();
$o = new Option($crud,$oIDs[0]);

echo $o->getOptionStatement();*/



?>