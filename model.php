<?php
Abstract class model {

    public function save()
    {   
        $modelName=static::$modelName;
        $tableName = $modelName::table();
        $array = get_object_vars($this);
    
   
        foreach ($array as $key =>$value){
            if (empty($value)){
                $array[$key] ='NULL';

            }
        }

        if ($this->id != '') {
            $sql = $this->update($array,$tableName);
        } else {
            
            $sql = $this->insert($array,$tableName);
        }

        $db = dbConn::getConnection();
        try {
            $statement = $db->prepare($sql);

            $statement->execute();
        
        } catch (PDOException $e){
            echo 'SQL error is:' . $e->getMessage();
        } 

        


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
    
        $statement = $db->prepare($sql);
        $statement ->execute();

        echo 'I just deleted record' . $this->id;

  	
       
     
    }

}

?>