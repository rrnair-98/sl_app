<DOCTYPE! HTML>
<?php
class Crud
{
    
    //public $v; variable definition should be with the access specifier.
    //Any variable defined within the constuctor should be donr with the help of this pointer.
    function __construct($servername,$username,$db)
    {
      $this->conn = new mysqli($servername, $username,"",$db);
      if ($this->conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);
        $this->arr=array(1,2,3,4);
        
    }
    


    
    function getData($id,$table)
    {
       
        
        $query="select * from $table where id=$id;";
        $result=mysqli_query($this->conn,$query);
        $row="hi";
        if(mysqli_num_rows($result)==1)
            {
                $row=mysqli_fetch_assoc($result);
            }
          //  $namee=$row['name'];
           // $row.="marks":"array(1,2,3)";
            $jf=Json_encode($row);
            echo $jf;
    }
    

    
    function insertData($name,$pass,$email,$table)
    {
       
        $stmt=$this->conn->prepare("Insert into $table(name,password,email) values(?,?,?);");
        $stmt->bind_param("sss",$name,$pass,$email);
        // $query="INSERT INTO $table(name,password,email) VALUES('$name','$pass' ,'$email');";
        if($stmt->execute()){
        echo "Record inserted";
        }
        else{
            echo "No rows affected";
        }
        
    
    }

    
    function updateData($id,$col,$nv,$table)
    {
  
        $stmt=$this->conn->prepare("update $table set $col=? where id=?;");
        $stmt->bind_param("ss",$col,$id);  ///Error boolean
        
       if($stmt->execute()){
        echo "Record updated";
    }
    else{
        echo "No rows affected";
    }
        
    }


    function deleteData($id,$table)
    {
        
        $ids="";
        $arr_len="";
       // $query="delete from $table where id IN($this->arr)";
        foreach($this->arr as $i)
        {
            $ids.=("$i,");
            $arr_len++;
        }
        $ids=rtrim($ids,",");

        $stmt=$this->conn->prepare("delete from $table where id IN(?);");
        $stmt->bind_param("s",$ids);
        
        if($stmt->execute()){
       
        echo "$arr_len rows affected";
        }
        else{
            echo "No rows affected";
        }
   
    }
    function __destruct(){
        $this->conn->close();
        
    }
}
?>

