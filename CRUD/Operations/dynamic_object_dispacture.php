<?php 
require_once 'read.php';
require_once 'update.php';
require_once 'delete.php';
require_once 'create.php';
require_once 'Exceptions.php';

class DynamicObjectDispacture extends GeneralExeption{
    public $con;
    public function __construct($con) {
        $this->con = $con;
        // $con = $this->$con->connect();
    }
    
    public function dispacture($operation,$table_name,$id=0,$data_update=0,$fealds="", $data_create=array()) {
        $json=0;
        switch ($operation) {
            //Create oprations
            case 'createEntry':
                $create = new Create($this->con);
                return $create->createEntry($table_name,$id,$data_create['email'],$data_create['name']);
                break;
            case 'createTable':
                $create = new Create($this->con);
                if($fealds==0)
                    throw new GeneralExeption("There is no name of Collum names provided in the arguments.",501);
                else
                    // echo $fealds; 
                    return $create->createTable($table_name,$fealds);
                    break;

            //Read operations
            case 'readEntry':
                $read = new Read($this->con);
                return $read->readEntry($id,$table_name);
                break;
            case 'readTable':
                $read = new Read($this->con);
                return $read->readTable($table_name);
                break;
                
            
            //Update operations
            case 'updateEntry':
                $update = new Update($this->con);
                return $update->updateEntry($id,$table_name,$data_update);
                break;

            //Delete operations
            case 'deleteEntry':
                $delete = new Delete($this->con);
                return $delete->deleteEntry($id,$table_name);
                break;
            case 'deleteTable':
                $delete = new Delete($this->con);
                return $delete->deleteTable($table_name);
                break;
            default:
                throw new GeneralExeption("Operation not found",502);
                break;
        }
    }

    public function __destruct() {
        // $this->con->close();
    }

    
}