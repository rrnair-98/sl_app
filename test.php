<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 29-11-2017
 * Time: 12:28
 */

include_once ('Layer2-Upload.php');

$crud = new Crud('localhost','root','','quizapp');

/*//$crud->insertData('inventory',array('name','price','status','created_at','updated_at'),array('Inven 21341421',1234,1,'NOW()','NOW()'));
*/
require_once('Classes/PHPExcel.php');
$excel = PHPExcel_IOFactory::load('Test_Run.xlsx');
$excel->setActiveSheetIndex(0);
$i=2;

 while($excel->getActiveSheet()->getCell('A'.$i)->getValue()!= "")
 {

     $optionArray = array();
     $id = $excel->getActiveSheet()->getCell('A'.$i)->getValue();
     $category = $excel->getActiveSheet()->getCell('B'.$i)->getValue();
     $m_statement = $excel->getActiveSheet()->getCell('C'.$i)->getValue();
     $statement = $excel->getActiveSheet()->getCell('D'.$i)->getValue();
     $op = array();
     $op[] = $excel->getActiveSheet()->getCell('E'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('F'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('G'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('H'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('I'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('J'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('K'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('L'.$i)->getValue();
     $op[] = $excel->getActiveSheet()->getCell('M'.$i)->getValue();

     for($j=0;$j<count($op);$j++)
     {
         if(strcmp($op[$j], NULL)!=0)
         {

            $optionArray[] = new OptionModel($op[$j],"");
         }
     }
     if((strcasecmp($category,"MCQ")==0)||(strcasecmp($category,"FIB")==0))
     {
         $statementForJSON = new QuestionToJSON($m_statement,$statement);
         if(strcasecmp($category,"MCQ")==0)
         {

             $options = array();
             for($count=0;$count<count($optionArray);$count++)
             {

                    $MCQOption = new MCQOption($optionArray[$count]->getStatement(),$optionArray[$count]->getImageCount());
                    $options[] = json_encode($MCQOption);
             }
             $type = 1;//MCQ
         }
         else
         {
             $optionStringArray = explode(",",end($optionArray)->getStatement());
             $FIBOption = new FIBOption($optionStringArray);
             $options = array(json_encode($FIBOption));
             $type= 2;//FIB

         }
     }
     else if(strcasecmp($category,"MTF")==0)
     {


         $type=3;
     }
     else
         $type=-1;
     if($type!=-1)
       //$upload = new UploadQuestion($crud,json_encode($statementForJSON),$type,2,$options,1,0,1);
     $i++;


 }



//$crud->getLastInsertedID();

//echo $crud->getDateTime();


