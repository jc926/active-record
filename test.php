<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);


define('DATABASE', 'jc926');
define('USERNAME', 'jc926');
define('PASSWORD', 'gkXLdWmKr');
define('CONNECTION', 'sql2.njit.edu');

class dbConn{
    //variable to hold connection object.
    protected static $db;
    //private construct - class cannot be instatiated externally.
    private function __construct() {
        try {
            // assign PDO object to db variable
            self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch (PDOException $e) {
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $e->getMessage();
        }
    }
    // get connection function. Static method - accessible without instantiation
    public static function getConnection() {
        //Guarantees single instance, if no connection object exists then create one.
        if (!self::$db) {
            //new connection object.
            new dbConn();
            
        }
        //return connection.
        return self::$db;

    }
}
/*
class collection {
    static public function create() {
      $model = new static::$modelName;
      return $model;
    }
    static public function findAll() {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet;
    }
    static public function findOne($id) {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
         //print_r($class);
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        //print_r($statement);
        $recordsSet =  $statement->fetchAll();
       // print_r($recordsSet[0]);
        return $recordsSet[0];
        
    }
}

class todos extends collection {
    protected static $modelName = 'todos';
}
class accounts extends collection {
    protected static $modelName = 'accounts';
 }

 //$test = todos::findAll();
 //print_r($test);
 //$test1 = todos:: findOne(3);
*/


class model {
    protected $tableName;
    //protected $columnString;
    public function save()
    {   
        
        $array = get_object_vars($this);
        //print_r($array);
        
        // $this->columnString = implode(',',$array);  another way to input 

        $columnString = implode(',', $array);
        //print($columnString);
        $valueString = ":".implode(',:', $array);
        //print($valueString);
        
        if ($this->id = '') {
            $sql = $this->insert($columnString,$valueString);
        } else {
            $sql = $this->update($array);
        }
        /*
        $db = dbConn::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
        $this->tableName;
        

       // echo "INSERT INTO $tableName (" . $columnString . ") VALUES (" . $valueString . ")</br>";
        echo 'I just saved record: ' . $this->id;
    }
    

    public function insert($columnString,$valueString) {
        $sql = 'INSERT into $tableName ('. $columnString .') VALUES ('. $valueString. ')</br>';
        return $sql;
    }
    /*
    private function update($array) {
        foreach ($array as $key => $value) {
            
            # code...
        }
        $sql = 'UPDATE'.$tableName. 'SET ('. C.') WHERE id = ('.$valueString. ')</br>';
        return $sql;
        echo 'I just updated record' . $this->id;
    }
    public function delete() {
        $db = dbConn::getConnection();          
        $sql = "DELETE FROM ". $this -> tableName. " WHERE id =".$this->id; 
        //print($sql);
        $tableName = get_called_class();
        $statement = $db->prepare($sql);
        $statement ->execute();
       
        //$array = get_object_vars($this);
        //print_r($array);
        $result = $statement->fetchAll();
        print_r($result);
        echo 'I just deleted record' . $this->id;

  	
       }
     */
    }
}

class B extends model {
    public $id;
    public $owneremail;
    public $ownerid;
    public $createddate;
    public $duedate;
    public $message;
    public $isdone;
    public function __construct()
    {
        $this->tableName = 'todos';
	
    }
}

//$record = new todos();
//$record->message = 'some task';
//$record->isdone = 0;

//print_r($record);
$test = new B();
$test->id = 1;
$test->owneremail = 'jc134@njit.edu';
$test->ownerid = 'jc1234';
$test->createddate = '11/18';
$test->duedate = '11/19';
$test->message = 'so hard';
$test->isdone = 3;
//$test->message = 'I love you';
//print_r($test);
//$test-> delete ();
$test-> save();

?>