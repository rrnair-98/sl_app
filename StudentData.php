<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class StudentData implements JsonSerializable,DatabaseConstants
{
    private $crud;
    private $studentDetails;
    private $studentSubject;
    function __construct($studentDetails,$studentSubject)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
        $this->studentSubject = $studentSubject;
        $this->studentDetails = $studentDetails;
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
?>