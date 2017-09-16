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
        
        function getQuestion($questionId)// pass questionID to get all details related to question except answer_id It returns a Json Object
        {
            $columns = array('question_id','level','statement','marks','probability','image_count','chapter_id');
            $result = $this->crud->getData($questionId,"question",$columns,"question_id");
            return $this->crud->getJson($result);
        }
        
        function getAnswer($questionId)// Pass questionId to get its answer. It returns a JsonObject with answerID
        {
            $columns = array('answer_id');
            $result = $this->crud->getData($questionId,"question",$columns,"question_id");
            return $this->crud->getJson($result);
        }
        
    }

?>