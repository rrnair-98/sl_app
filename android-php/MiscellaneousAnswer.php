<?php

/**

 * Created by PhpStorm.

 * User: enzo

 * Date: 12/10/2017

 * Time: 2:26 AM

 */



class MiscellaneousAnswer implements DatabaseConstants

{

    /*Unique ID*/

    private $miscellaneousAnswerId;

    /*statement answered by the user */

    private $miscellaneousStatement;

    /*reference to the id in answer sheet table*/

    private $miscellaneousAnswerSheetId;



    private $crud;



    public function __construct($id){

        $this->miscellaneousAnswerSheetId=$id;

        $this->crud = Crud::getInstance(MiscellaneousAnswer::SERVER,

            MiscellaneousAnswer::USERNAME,MiscellaneousAnswer::PASSWORD,

            MiscellaneousAnswer::DATABASE);

        $result = $this->crud->getData($this->miscellaneousAnswerSheetId,"answer",array("answer_id"

        ,"statement","answer_sheet_id"),"answer_sheet_id");

        if(count($result)>0){
            $this->miscellaneousAnswerId = $result[0]['answer_id'];

            $this->miscellaneousStatement = $result[0]['statement'];
        }

    }



    /**

     * return miscellaneous answer id

     */

    public function getMiscellaneousAnswerId()

    {

        return $this->miscellaneousAnswerId;

    }



    /**

     * return miscellaneous answer statement

     */

    public function getMiscellaneousStatement()

    {

        return $this->miscellaneousStatement;

    }



    /**

     * return miscellaneous answer sheet id

     */

    public function getMiscellaneousAnswerSheetId()

    {

        return $this->miscellaneousAnswerSheetId;

    }



    public function getJson(){

        $string = "{";

        $string.="\"answer_sheet_id\":".$this->miscellaneousAnswerSheetId;

        $string.=",\"miscelaneous_id\":".$this->miscellaneousAnswerId;

        $string.=",\"miscelaneous_statement\":".$this->miscellaneousStatement;

        $string.="}";

        return $string;

    }

}

?>