
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
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet[0];
    }
}
class accounts extends collection {
    protected static $modelName = 'account';
}
class todos extends collection {
    protected static $modelName = 'todo';
}
class model {
    protected $tableName;
    public function save()
    {
        if ($this->id = '') {
            $sql = $this->insert();
        } else {
            $sql = $this->update();
        }
        $db = dbConn::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
        $tableName = get_called_class();
        $array = get_object_vars($this);
        $columnString = implode(',', $array);
        $valueString = ":".implode(',:', $array);
       // echo "INSERT INTO $tableName (" . $columnString . ") VALUES (" . $valueString . ")</br>";
        echo 'I just saved record: ' . $this->id;
    }
    private function insert() {
        $sql = 'sometthing';
        return $sql;
    }
    private function update() {
        $sql = 'sometthing';
        return $sql;
        echo 'I just updated record' . $this->id;
    }
    public function delete() {
        echo 'I just deleted record' . $this->id;
    }
}
class account extends model {
}
class todo extends model {
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
// this would be the method to put in the index page for accounts
$records = accounts::findAll();
//print_r($records);
// this would be the method to put in the index page for todos
$records = todos::findAll();
//print_r($records);
//this code is used to get one record and is used for showing one record or updating one record
$record = todos::findOne(1);
//print_r($record);
//this is used to save the record or update it (if you know how to make update work and insert)
// $record->save();
//$record = accounts::findOne(1);
//This is how you would save a new todo item
$record = new todo();
$record->message = 'some task';
$record->isdone = 0;
//$record->save();
print_r($record);
$record = todos::create();
print_r($record);


/*
// refelection:  miiro image of a class or funtion. doing it because it can tell you sth.
$tableName= get_called_class(); 

// extend collection to differnet table, so that i don't need to repeat SQL. only change the table name

$class = static :: $modelName; // I wanto to go to database, I wnat then to bo oject. reaseon is that each one is object, they can have functionity and propetity.  we can add method to delete it .if each todo

// model class have，  save method.
class todos extends collection{

	proetcted static $modelName=  'todo'; //problemtic, we need to figure out
}

// if you want to find only one record. 

// change findALL() to findOne(1), then change the SQL to where id =1.  return recordsSet[0];
$arrary = get_object_vars($this)

//final project is about  create a class XXX sextends collection, then can use insert/update/  and combine your privous proejct(upload/display). 

$record = new todo();  // need to fix from here. not appropriate
$record = 

//right way,fixed
class collection{

	public function create(){
		$model = new static :: $modelName; 
		return $model;
	}
}

Class accounts {
	protected static $modelName = 'todo'

}
$todo  = accounts :: create();

// understand scope, where you can access.  problem is how to get the right scope.
// $this is how u resolve scope for oject and 
// self is the scope resulaton for static , 

//relationship (present/child)


extends can only extend one class(parent/child)
interface (methods) is a peer relationship, implements () to more than 1 to combine 

add interface to collection and model class. 
interface collection
public function get tablename

class account implements collection
public function get tablename  (reference interface)

namespacing: logic folders/storage/files in your program
eg: myproject/database/connection.php
    <？php
    namespace my project\database
    class connection{
	//handling database connections
    }
homework:

a database folder
connection.php, collections.php, each class.php 
each file in the top, 

make you proejct works files and folder
namespacing folder
class   files.

namespacing first working then
autoloder   one file
class folder 

interfaces on its own

generate table 
for each loop can only do  for array, can't do for object.
convert the model form object to an array (typecast)




*/

?>
