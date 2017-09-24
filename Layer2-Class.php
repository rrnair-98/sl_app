<?php

include_once('Crud.php');

class StudentDetails
{
    
    private $crud;
    private $studentID;
    private $branch;
    private $semester; 
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
            
            $this->branch = array('branch_id'=>$result[0]['branch_id'],'branch_name'=>$result[0]['branch_name']);
            $this->semester = array('semester_id'=>$result[0]['semester_id'],'semester_name'=>$result[0]['semester_name']);
    }
    
    function getStudentBranch()//Return Result Set with Branch ID and name
    {
        return $this->branch;
        
    }
    
    function getStudentSemester()//Return Result Set with Semester ID and name
    {
        return $this->semester;
    }
    
    function getStudentBranchJSON()//Return JSON Object with Branch ID and name
    {
        return $this->crud->getJson($this->branch);
        
    }
    
    function getStudentSemesterJSON() //return JSON object with Semester ID and name
    {
        return $this->crud->getJson($this->semester);
    }
    
    function getStudentBranchID()//Return Result Set with Branch ID and name
    {
        return $this->branch['branch_id'];
        
    }
    
    function getStudentSemesterID()//Return Result Set with Semester ID and name
    {
        return $this->semester['semester_id'];
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
    function __construct($crud,$studentDetails)
    {
        $this->crud = $crud;
        $this->studentID = $studentDetails->getStudentID();
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
                $this->subjects[] = $result[$i][0];
            
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
            $subject = $this->subjects[$i];
            $subID[] = $subject['subject_id'];
            
        }
        return $subID;
    }
    
    function getSubjectNames()
    {
        $subNames = array();
        for($i=0;$i<count($this->subjects);$i++)
        {
            $subject = $this->subjects[$i];
            $subNames[] = $subject['name'];
            
        }
        return $subNames;
        
    }
    
}

class Subject
{
    private $crud;
    private $subjectID;
    private $subjectName;
    
    function __construct($crud,$subjectID)
    {
        $this->crud = $crud;
        $this->subjectID = $subjectID;
        $this->fetchSubjectName();
    }
    
    private function fetchSubjectName()
    {
        $columns = array('name');
        $result = $this->crud->getData($this->subjectID,"subject",$columns,"subject_id");
        $this->subjectName = $result[0]['name'];
        
    }
    
    function getSubjectID()
    {
        return $this->subjectID;    
    }
    
    function getSubjectName()
    {
        return $this->subjectName;
    }
    
}

class SubjectChapter
{
    private $crud;
    private $subjectID;
    private $chapters;
    
    function __construct($crud,$subject)
    {
        $this->crud = $crud;
        $this->subjectID = $subject->getSubjectID();
        $this->fetchChapters();
    }
    
    private function fetchChapters()
    {
        $columns = array('chapter_id','name','weightage');
        $this->chapters = $this->crud->getData($this->subjectID,"chapter",$columns,"subject_id");
        
                
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
            $chapter = $this->chapters[$i];
            $chapterID[] = $chapter['chapter_id'];
            
        }
        return $chapterID;
    }
    
    function getChapterNames()
    {
        $chapterNames = array();
        for($i=0;$i<count($this->chapters);$i++)
        {
            $chapter = $this->chapters[$i];
            $chapterNames[] = $chapter['name'];
            
        }
        return $chapterNames;
        
    }
    

}


class Chapter
{
    private $crud;
    private $chapterID;
    private $chapterName;
    private $chapterWeightage;
    
    function __construct($crud,$chapterID)
    {
        $this->crud = $crud;
        $this->chapterID = $chapterID;
        $this->fetchChapterDetails();
    }
    
    private function fetchChapterDetails()
    {
        $columns = array('name','weightage');
        $result = $this->crud->getData($this->chapterID,"chapter",$columns,"chapter_id");
        $this->chapterName = $result[0]['name'];
        $this->chapterWeightage = $result[0]['weightage'];
        
        
    }
    
    function getChapterID()
    {
        return $this->chapterID;
    }
    
    function getChapterName()
    {
        return $this->chapterName;
    }
    
    function getChapterWeightage()
    {
        return $this->chapterWeightage;
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
/*

$crud = new Crud("localhost","root","","quizapp");

$sd = new StudentDetails($crud,1);
$ss = new StudentSubject($crud,$sd);

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

echo $o->getOptionStatement();
*/


?>