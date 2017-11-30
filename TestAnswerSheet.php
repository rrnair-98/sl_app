<?php
require_once ("Crud.php");
require_once ("DatabaseConstants.php");
class TestAnswerSheet implements DatabaseConstants
{
    private $crud;
    private $test_id;
    private $answer_sheets;
    function __construct($test_id)
    {
        $this->crud = Crud::getInstance(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE);
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
            $this->answer_sheets[] = new AnswerSheet($result[$i]['answer_sheet_id']);
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
    /*returns an entire answer sheet for the passed Test Id*/
    public function generateTestAnswerSheet($testId){
        $query = "SELECT answer_sheet.answer_sheet_id,answer_sheet.test_id, answer_sheet.question_id,question.statement 
            as question_staement,question.marks,question.answer_id ,options.statement as answer_statement,
            answer_sheet.selected_option_id,options.statement as selected_option_statement 
            from answer_sheet,question,options where answer_sheet.question_id = question.question_id AND 
            question.answer_id = options.option_id AND answer_sheet.selected_option_id = options.option_id;";
        $result = $this->crud->executeQuery($query);

    }
}
?>