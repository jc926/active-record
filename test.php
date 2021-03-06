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

Abstract class collection {
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
    protected static $modelName = 'todo';
}
class accounts extends collection {
    protected static $modelName = 'account';
 }

 //$test = todos::findAll();
 //print_r($test);
 //$test1 = todos:: findOne(3);



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
     //  echo 'I just saved record: ' . $this->id;
        
    }
      
    
    private function insert($array,$tableName) {
     
        $columnString = implode(',', array_keys($array));

        $valueString = implode(',', $array);
   

        $sql = "INSERT INTO ". $tableName. " (" . $columnString . ") VALUES (".$valueString.")";
    
        return $sql;
    //    echo 'I just inserted record' . $this->id;
        

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
      //  echo 'I just updated record' . $this->id;
        
       
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
       // echo 'I just deleted record' . $this->id;

  	
       
     
    }

}
class account extends model{
    public $id;
    public $email;
    public $fname;
    public $lname;
    public $phone;
    public $birthday;
    public $gender;
    public $password;
    protected static $modelName = 'account';
    public static function table(){
        $tableName = 'accounts';
        return $tableName;
    }
}

class todo extends model {
    public $id;
    public $owneremail;
    public $ownerid;
    public $createddate;
    public $duedate;
    public $message;
    public $isdone;
    protected static $modelName = 'todo';
    public static function table(){
        $tableName = 'todos';
        return $tableName;
    }
    /*
    public function __construct()
    {
        $this->tableName = 'todos';
	
    }*/
}

class htmltag{
    public static function htmlstart(){
        return '<html>';
    }
    public static function htmlend(){
        return '</html>';
    }    

    public static function tablestart(){
        return '<table style = "width:100%" border = "1"collapse="2">';
    }
    public static function tableend(){
        return '</table><hr>';
    }
    public static function tablehead($data){
        return '<th>'. $data . '</th>';
    }

     public static function rowstart(){
        return '<tr>';
    }
    public static function rowend(){
        return '</tr>';
    }
    public static function tabledata($data){
        return '<td>' . $data . '</td>';
    }    
    public static function bodystart(){
        return '<body>';
    }
    public static function bodyend(){
        return '</body>';
    }
}

class htmltable{
    public static function Atable($input){
       
        $table = htmltag:: tablestart();
        foreach ($input as $row =>$line){
            $table.= htmltag:: rowstart();
            foreach ($line as $inrow =>$value){
                $table.=htmltag::tablehead($inrow);
            }
            $table.=htmltag:: rowend();
            break 1;
        }
        foreach ($input as $row =>$line){
            $table.= htmltag:: rowstart();
            foreach ($line as $inrow =>$value){
                $table.=htmltag::tabledata($value);
            }
            $table.=htmltag:: rowend();
        }
        $table .= htmltag::tableend();
        return $table;   

    }

}




//$record = new todos();
//$record->message = 'some task';
//$record->isdone = 0;

//print_r($record);

$test = new todo();

$test->id = '1';
$test->owneremail = '@njit.edu';
//$test->ownerid = 'jc1234';
//$test->createddate = '11/18';
//$test->duedate = '11/19';
//$test->message = "'so hard'";
//$test->isdone = "'1'";

//$test->message = 'I love you';
//print_r($test);
//$test->id = '8';
//$test-> delete ();

$test-> save();
print(htmltable::Atable(todos::findAll()));
$newA= new account();
$newA->fname ="'jie'";
$newA->lname = "'cai'";
$newA -> save();


?>