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
    $this->arra=array(1,2,3,4);
    }
    
    function deleteData($table,$del_array)
    {
        
        $bindTypes= $this->getBindType($del_array);
        $questionString=$this->getPlaceholder(count($del_array));
       
       // $query="delete from $table where id IN($this->arr)";
        
        
        $stmt=$this->conn->prepare("delete from $table where id IN($questionString);");
        
        
        call_user_func_array(array($stmt, 'bind_param'),array_merge(array($bindTypes),$this->getParams($del_array)));
        if($stmt->execute())
        {
            $ar=$stmt->affected_rows;
        echo "$ar Rows deleted";
        }
        
        
   
    }
function insert($table,$columns,$values)
{
    
    $bindTypes = getBindType($values);//get the bind type for each value. eg it will return ss or sss or si etc
    
    insert($table,$columns,$values,$bindTypes);
}


function insertData($table,$columns,$values)
{
    
    $bindTypes = $this->getBindType($values);//get the bind type for each value. eg it will return ss or sss or si etc
    
    $questionMarkString = $this->getPlaceholder(count($values));//returns string with number of question marks
    
   // $params = $this->getParams($values); //returns array with reference paramters required by bind_param
    
    $columnList = implode(',',$columns);
    
    $stmt = $this->conn->prepare("INSERT INTO $table($columnList) VALUES($questionMarkString);"); //end query semicolon optional
    
    
    call_user_func_array(array($stmt, 'bind_param'),array_merge(array($bindTypes), $this->getParams($values)));//uses to pass bind params to mysqli bind_param
    if($stmt->execute())
    {
            $ar=$stmt->affected_rows;
        echo "$ar Rows inserted";
    }
    
    
    
}

function getBindType($values)
{
    $dt="";
    $ar=array();
    
     for($i=0;$i<count($values);$i++)
     {
        $dt=gettype($values[$i]);
         switch($dt)
        {
            case "integer":
            {
                
                $ar[]="i";
                break;
            }
            case "string":
            {
            
                $ar[]="s";
                break;
            }
            case "double":
            {
                
                $ar[]="d";
                break;
            }
            default:
            {
                
                $ar[]="b";
            }
        }
        
     }
    return implode('',$ar);//glue the parameters without spaces between them
        
    
        
}

function getPlaceHolder($count)
{
    $qt=array();
    for($i=0;$i<$count;$i++)
    {
        $qt[]="?";
    }
   
    return implode(",",$qt);// glue question marks using , as delimiter
}

function getParams($values)
{
    $params= array();
    for($i = 0; $i< count($values); $i++)
    {
        $params[$i] = &$values[$i];
        
    }
    return $params;
}


    
    function getData($id,$table)
    {
       
        
        
        $query="select * from $table";
        $result=mysqli_query($this->conn,$query);
        
        //$myArray='{"'.$table.'":';
        $myArray=array();
        while($row=$result->fetch_array(MYSQL_ASSOC))
        {
            $myArray[]=$row;
        }
        
        /*if(mysqli_num_rows($result)==1)
            {
                $row=mysqli_fetch_assoc($result);
                
            }*/
            
          //  $namee=$row['name'];
            //$row="marks".":array(1,2,3)";
            
            $jsonString = '{"'.$table.'":'.json_encode($myArray)."}";
            echo $jsonString;
    }
    

    
  
    
    function updateData($id,$columns,$values,$table)
    {
  
        $columnList="";
        foreach($columns as $i)
        {
            $columnList.="$i=?,";
        }
        $cL=rtrim($columnList,",");
        
        $bindTypes = $this->getBindType($values);//get the bind type for each value. eg it will return ss or sss or si etc
    
     
    
    
    $stmt = $this->conn->prepare("UPDATE $table set $cL where id=$id;");
    
   
        //$params=array_merge(array($bindTypes),$this->getParams($values));
  call_user_func_array(array($stmt, 'bind_param'),array_merge(array($bindTypes),$this->getParams($values)));//uses to pass bind params to mysqli bind_param
    if($stmt->execute())
        {
            $ar=$stmt->affected_rows;
        echo "$ar Rows updated";
        }
       
        
    }

    function __destruct(){
        $this->conn->close();
        
    }
    

}

?>

