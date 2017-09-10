<DOCTYPE! HTML>
<html>
    <head>DATABASE CRUD operations</head>
<?php
include('Crud.php');

$servername = "localhost";
$username = "root";
$db="college";
$table="users";
$password='';


$crud= new Crud($servername,$username,$password,$db);


  //Object of crud class creation.

if(isset($_POST['submit']))
{
    $id=$name=$email=$pass="";

    $name=$_POST['name'];

    $pass=$_POST['password'];
    
    $email=$_POST['email'];
    
    $columns=array('username','email','password');
    
    $values=array($name,$email,$pass);
    
    $crud->insertData($table,$columns,$values);
   
        
}
if(isset($_POST['delete-button']))
{
     $crud->deleteData(4,$table);
}
if(isset($_POST['update-button']))
{
    $crud->updateData(2,'name','prachi',$table);
}

if(isset($_POST['return-records']))
{
    $crud->getData(4,$table);
}
?>
<body>
<form action="?<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">

    <label>First Name:</label>
    <input type="text" name="name" ><br>
    
    
    <label>Password:</label><br>
    <input type="password" name="password" ><br>
                
    <label>Email:</label>
    <input type="email" name="email" ><br>
    
     <input type="submit" name="submit" Value="Enter">
     
     <input type="submit" name="delete-button" Value="delete">
     <input type="submit" name="update-button" Value="update">
     <input type="submit" name="return-records" Value="return">
 
</form>
</body>
</html>
