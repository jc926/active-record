
<?php


/*

Just class notes/comments


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
