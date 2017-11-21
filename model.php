<?php
Abstract class model {
    //protected $tableName;
    //protected $columnString;
    public function save()
    {   
        $modelName=static::$modelName;
        $tableName = $modelName::table();
        $array = get_object_vars($this);
        //print_r($array);
   
        foreach ($array as $key =>$value){
            if (empty($value)){
                $array[$key] ='NULL';

            }
        }
        //echo"<br><br>";
       // print_r(array_flip($array));
        //echo"<br><br>";
        // $this->columnString = implode(',',$array);  //another way to input 

        //$columnString = implode(',', $array);
        //$columnString2 = implode(',', array_flip($array)); //try professor's code
        //print($columnString);
        //echo"<br><br>";
        //print($columnString2);
        //echo"<br><br>";
        //$valueString = ":".implode(',:', $array);
        //$valueString2 = ':'.implode(',:', array_flip($array)); 
        //print($valueString);
        //echo"<br><br>";
        //print($valueString2);
        //echo"<br><br>";
        if ($this->id != '') {
            $sql = $this->update($array,$tableName);
        } else {
            
            $sql = $this->insert($array,$tableName);
        }

        $db = dbConn::getConnection();
        try {
            $statement = $db->prepare($sql);
            /*foreach($fliparray as $key => $value){
                $statement->bindParam(":$value",$this->value);
            }*/

        //print($sql);
    
            $statement->execute();
            //$id = $db->lastInsertId();
        } catch (PDOException $e){
            echo 'SQL error is:' . $e->getMessage();
        } 
        
        //$tableName = get_called_class();
        //$this->tableName;
        

       // echo "INSERT INTO $tableName (" . $columnString . ") VALUES (" . $valueString . ")</br>";
        echo 'I just saved record: ' . $this->id;
        
    }
      
    
    private function insert($array,$tableName) {
     
        $columnString = implode(',', array_keys($array));

        $valueString = implode(',', $array);
   

        $sql = "INSERT INTO ". $tableName. " (" . $columnString . ") VALUES (".$valueString.")";
        print($sql);
        return $sql;
        echo 'I just inserted record' . $this->id;
        

    }
    
    private function update($array,$tableName) {

        $temp = '';
        $sql = 'UPDATE '.$tableName. ' SET ';
        foreach($array as $key=>$value){
            if(! empty($value)){
                $sql.="$temp". $key . '="'.$value. '"';
                $temp =", ";

            }
        }
        $sql .= ' WHERE id= '.$this->id;
    
        /*
        foreach ($array as $key => $value) {
            if($key=='id'){
                $sql=$temp.=$key.'= "'.$value.'"';

            }else{
                $sql=$temp.=','.$key.'="'.$vlaue.'"';
            }
            
        }
        $sql .= ' WHERE id= '.$this->id;
        print($sql);
        //$sql = 'UPDATE '.$this->tableName. ' SET '. $temp .' WHERE id = '.$this->id; //has a problem
        //print($sql);*/
        return $sql;
        echo 'I just updated record' . $this->id;
        
       
    }
    

    public function delete() 
    {
        $db = dbConn::getConnection(); 
        $modelName=static::$modelName;
        $tableName = $modelName::table();
        $sql = "DELETE FROM ". $tableName. " WHERE id =".$this->id; 
        print($sql);
        //$tableName=get_called_class();
        $statement = $db->prepare($sql);
        $statement ->execute();
        //$array = get_object_vars($this);
        //print_r($array);
        //$result = $statement->fetchAll();
        //print_r($result);
        echo 'I just deleted record' . $this->id;

  	
       
     
    }

}

?>