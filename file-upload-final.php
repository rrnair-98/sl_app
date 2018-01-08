<?php



//check if the insert was pressed
if(isset($_POST['btnSubmit'])){
    $errors = array();
    $uploadedFiles = array();
    $extension = array("jpeg","jpg","png","gif","xlsx","xls");
    $bytes = 1024;
    $KB = 1024;
    $totalBytes = $bytes * $KB;
    $excelFilePath = "../excel/";
    $UploadFolder = "../images";
    $excelFile = "";
    $counter = 0;
    $flag=0;

    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];

        if(empty($temp))
        {
            break;
        }
        $UploadOk = true;

        $counter++;

        if($_FILES["files"]["size"][$key] > $totalBytes||$_FILES["files"]["size"][$key] = 0)
        {
            $UploadOk = false;
            array_push($errors, $name." file size is larger than the 1 MB. or it is empty");
        }

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if(in_array($ext, $extension) == false)
        {


            $UploadOk = false;
            array_push($errors, $name." is invalid file type.");
        }

        if(file_exists($UploadFolder."/".$name) == true){
            $UploadOk = false;
            array_push($errors, $name." file is already exist.");
        }
        if(($ext=="xls" || $ext=="xlsx")&& $flag==1)
        {
            $UploadOk = false;
            array_push($errors, "Only One Excel file allowed");

        }

        if($UploadOk == true){

            $old = $UploadFolder;
            if(strcmp($ext,"xls")==0 || strcmp($ext,"xlsx")==0) {
                $flag = 1;

                $excelFile = $name;
                $UploadFolder = $excelFilePath;


            }
            move_uploaded_file($temp,$UploadFolder."/".$name);
            array_push($uploadedFiles, $name);
            $UploadFolder = $old;
            echo $flag;
        }
    }

    if($counter>0){
        if(count($errors)>0)
        {
            echo "<b>Errors:</b>";
            echo "<br/><ul>";
            foreach($errors as $error)
            {
                echo "<li>".$error."</li>";
            }
            echo "</ul><br/>";
        }

        if(count($uploadedFiles)>0){
            echo "<b>Uploaded Files:</b>";
            echo "<br/><ul>";
            foreach($uploadedFiles as $fileName)
            {
                echo "<li>".$fileName."</li>";
            }
            echo "</ul><br/>";

            echo count($uploadedFiles)." file(s) are successfully uploaded.";
        }
    }
    else{
        echo "Please, Select file(s) to upload.";
    }
    if($UploadOk && $flag==1) {
        include_once("create-upload-json.php");
        $upload = new UploadToDB();
        $upload->upload($excelFilePath,$excelFile);
    }


}


?>

<html>
<head>
    <title></title>
</head>

<body>

<form method="post" enctype="multipart/form-data" name="formUploadFile">
    <label>Select file to upload:</label>
    <input type="file" name="files[]" multiple="multiple" />

    <input type="submit" value="Upload File" name="btnSubmit"/>
</form>

</body>
</html>
