<?php
/**
 * Created by PhpStorm.
 * User: ADMIN-PC
 * Date: 18-12-2017
 * Time: 06:01 PM
 */

include_once ('StudentDetails.php');
include_once ('StudentData.php');
include_once ('StudentSubject.php');

$email = $_POST['email'];

$studentDetails = new StudentDetails($email);
$studentSubject = new StudentSubject($email);

$studentData = new StudentData($studentDetails,$studentSubject);

echo json_encode($studentData);

?>