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
     $image_count=0;
     $optionArray = array();
     $id = $excel->getActiveSheet()->getCell('A'.$i)->getValue();
     $category = $excel->getActiveSheet()->getCell('B'.$i)->getValue();
     $m_statement = $excel->getActiveSheet()->getCell('C'.$i)->getValue();
     $statement = $excel->getActiveSheet()->getCell('D'.$i)->getValue();
     $statement_image = "";
     if(file_exists("../images/".$statement)&& (strcmp($statement, NULL)!=0))
     {
            $statement_image = "../images/".$statement;
            $statement = "";
            $image_count = 1;
     }
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
             if(file_exists("../images/".$op[$j]))
             {
                 $optionArray[] = new OptionModel("",1,"../images/".$op[$j]);
             }
             else
             {
                 $optionArray[] = new OptionModel($op[$j],0,"");
             }


         }
     }
     if((strcasecmp($category,"MCQ")==0)||(strcasecmp($category,"FIB")==0))
     {
         $statementForJSON = new QuestionToJSON($m_statement,$statement,$statement_image);
         if(strcasecmp($category,"MCQ")==0)
         {

             $options = array();
             for ($count = 0; $count < count($optionArray); $count++) {
                 if ($optionArray[$count]->getImageCount() > 0)
                     $MCQOption = new MCQOption("", $optionArray[$count]->getImageUrl());

                 else
                     $MCQOption = new MCQOption($optionArray[$count]->getStatement(), "");

                 $options[] = json_encode($MCQOption);
             }
             $type = 1;//MCQ
         }


         else
         {
             $options = array();
             $optionStringArray = explode(",",end($optionArray)->getStatement());
             $FIBOption = new AnswersOption($optionStringArray);
             $options = array(json_encode($FIBOption));
             $type= 2;//FIB

         }
     }
     else if(strcasecmp($category,"MTF")==0)
     {
         $questions = array();

        for($count=0;$count<(count($optionArray)/2)-1;$count++)
        {
          /*  if(file_exists("../images/".$optionArray[$count]->getStatement()))
            {
                $images[] = $optionArray[$count]->getStatement();
                $questions[] = "";
            }
            else
            {
                $images[] = "";
            }*/
            $questions[] = $optionArray[$count];


        }

         $statementForJSON = new QuestionsToJSON($m_statement,$questions);
        $options = array();
        for($count=(count($optionArray)/2);$count<count($optionArray)-1;$count++)
        {

                if ($optionArray[$count]->getImageCount() > 0)
                    $MTFOption = new MTFOption("",$optionArray[$count]->getImageUrl(),($count+1)-(count($optionArray)/2));

                else
                    $MTFOption = new MTFOption($optionArray[$count]->getStatement(),"",($count+1)-(count($optionArray)/2));


            $options[] = json_encode($MTFOption);
        }



        $optionPairs = explode(",",$optionArray[count($optionArray)-1]->getStatement());
        $answers = array();
        for($count=0;$count<count($optionPairs);$count++)
        {
            $answer = explode("-",$optionPairs[$count]);
            $answers[] = strval($answer[1]-(count($optionArray)-1)/2);
        }


        $finalAnswer = new AnswersOption($answers);
        $options[] = json_encode($finalAnswer);

        $type=3;
     }
     else
         $type=-1;
    print_r($options);
    echo "<br>";
    echo json_encode($statementForJSON);
     echo "<br>";
     if($type!=-1)
       $upload = new UploadQuestion($crud,json_encode($statementForJSON),$type,2,$options,1,$image_count,1);
     $i++;


 }



//$crud->getLastInsertedID();

//echo $crud->getDateTime();


