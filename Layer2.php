<?php

    include_once('Crud.php');
    
    class StudentDetails
    {
        private $crud;
        function __construct($crud)
        {
            $this->crud = $crud;
        }
        
        function getStudentDetails($studentId) // Pass the student id to get student's branch and semester from database returns Json Object   
        {
            $columns = array('branch_id','branch_name','semester_id','semester_name');
            $result = $this->crud->getData($studentId,"student_sem_branch_mapping",$columns,"user_id");
            return $this->crud->getJson($result);
            
        }
        function getSubjects($studentId) //pass student id to get the subjects student has enrolled for. Returns json array with subject ID
        {
            $columns = array('subject_id');
            $result = $this->crud->getData($studentId,"enrolls",$columns,"user_id");
            return $this->crud->getJsonArray('subject',$result);
        }
        
        function getChapters($subjectId)//pass subject id to get chapters in that subject. It returns an Json Array with chapter id and name
        {
            $columns = array('chapter_id','name');
            $result = $this->crud->getData($subjectId,"chapter",$columns,"subject_id");
            return $this->crud->getJsonArray('chapter',$result);
        }
        
        function getQuestions($questionId)// pass questionIDs to get all details related to question except answer_id It returns a JsonArray with all questions
        {
            $count = count($questionId);
            $i=0;
            $columns = array('question_id','level','statement','marks','probability','image_count','type','chapter_id');
            $wholeresult = array();
            while ($i<$count)
            {
                $result = $this->crud->getData($questionId[$i],"question",$columns,"question_id");
                $i++;
                $wholeresult = array_merge($wholeresult,$result);
            }
            
            echo $this->crud->getJsonArray('question',$wholeresult);
        }
        
        function getAnswer($questionId)// Pass questionId to get its answer. It returns a JsonObject with answerID
        {
            $columns = array('answer_id');
            $result = $this->crud->getData($questionId,"question",$columns,"question_id");
            return $this->crud->getJson($result);
        }
        
        function getQuestionsForChapter($chapterID)//Returns a result set with question IDs for the chapter and all the decision parameters related to it
        {
            $columns = array('question_id','level','marks','probability','type');
            $result = $this->crud->getData($chapterID,"question",$columns,"chapter_id");
            return $result;
        }
        
        function insertBranch($name)
        {
            $columns = array('name','created_at','updated_at');
            date_default_timezone_set('Asia/Kolkata'); 
            $dt = date('Y-m-d H:i:s');
            return $this->crud->insertData('branch',$columns,array($name,$dt,$dt),'sss');
            
        }
        function insertSemester($name,$branchID)
        {
            $columns = array('name','branch_id','created_at','updated_at');
            date_default_timezone_set('Asia/Kolkata'); 
            $dt = date('Y-m-d H:i:s');
            return $this->crud->insertData('semester',$columns,array($name,$branchID,$dt,$dt),'siss');
            
        }
        
        function insertSubject($name,$semesterID)
        {
            $columns = array('name','semester_id','created_at','updated_at');
            date_default_timezone_set('Asia/Kolkata'); 
            $dt = date('Y-m-d H:i:s');
            return $this->crud->insert('subject',$columns,array($name,$semesterID,$dt,$dt));
        }
        
        function insertChapters($name,$weightage,$subjectID)
        {
            $columns = array('name','subject_id','weightage','created_at','updated_at');
            date_default_timezone_set('Asia/Kolkata'); 
            $dt = date('Y-m-d H:i:s');
            return $this->crud->insert('chapter',$columns,array($name,$subjectID,$weightage,$dt,$dt));
            
        }
        
        
    }

   $servername = "localhost";
    $username = "root";
    $db="quizapp";
    $crud =  new Crud($servername,$username,$db);
    $sd = new StudentDetails($crud);
    $sd->insertSubject('Dummy Subject 1','1');

?>